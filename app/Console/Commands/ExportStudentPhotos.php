<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Student;
use Intervention\Image\Facades\Image;
use ZipArchive;

class ExportStudentPhotos extends Command
{
    protected $signature = 'students:export-photos';
    protected $description = 'Export all student photos as JPG with rollno filenames, reduced size, and zip them';

    public function handle()
    {
        $students = Student::all();

        // Where original photos are stored
        $storagePath = storage_path('app/public/');

        // Export directory
        $exportPath = storage_path('app/public/exported_photos');
        if (!file_exists($exportPath)) {
            mkdir($exportPath, 0777, true);
        }

        foreach ($students as $student) {
            if (!$student->photo || !file_exists($storagePath . $student->photo)) {
                $this->warn("Photo not found for student ID: {$student->id}");
                continue;
            }

            $imagePath = $storagePath . $student->photo;
            $img = Image::make($imagePath)->encode('jpg', 75); // Start at 75% quality

            // Loop compression until target size (~25KB)
            $quality = 75;
            while (strlen($img) > 25 * 1024 && $quality > 10) {
                $quality -= 5;
                $img = Image::make($imagePath)->encode('jpg', $quality);
            }

            // Save as rollno.jpg
            $filename = $exportPath . '/' . $student->rollno . '.jpg';
            $img->save($filename);

            $this->info("Saved: {$student->rollno}.jpg (" . round(strlen($img) / 1024, 2) . " KB)");
        }

        // Create ZIP file
        $zipFile = storage_path('app/public/student_photos.zip');
        $zip = new ZipArchive;
        if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            foreach (glob($exportPath . '/*.jpg') as $file) {
                $zip->addFile($file, basename($file));
            }
            $zip->close();
            $this->info("✅ Photos zipped successfully: " . $zipFile);
        } else {
            $this->error("❌ Failed to create ZIP file");
        }

        $this->info('🎉 All student photos exported and zipped!');
    }
}
