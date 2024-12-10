<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DownloadImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:download';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Descargar imágenes de los artículos y guardarlas en storage.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $images = [
            'Intel Core i7 11700K' => 'https://images.unsplash.com/photo-1588062125097-a262dbbba931',
            'AMD Ryzen 5 5600X' => 'https://images.unsplash.com/photo-1593642634367-d91a135587b5',
            // Añade el resto de las imágenes aquí
        ];

        foreach ($images as $name => $url) {
            try {
                $imageContent = file_get_contents($url);
                $filename = str_replace(' ', '_', strtolower($name)) . '.jpg'; // Nombre amigable
                Storage::disk('public')->put('articles/' . $filename, $imageContent);
                $this->info("Imagen guardada: $filename");
            } catch (\Exception $e) {
                $this->error("Error al descargar $name: " . $e->getMessage());
            }
        }
    }
}
