<?php

namespace App\Services;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class QrCodeService
{
    public function generateQrCode(string $data): string
    {
        
        // Création de l'instance QR Code
        $qrCode = new QrCode($data);
        $qrCode->getSize(300); // Définir la taille
        $qrCode->getMargin(10); // Définir la marge

        // Utilisation d'un Writer pour générer un PNG
        $writer = new PngWriter();
        $result = $writer->write($qrCode);

        // Générer un nom de fichier unique
        $fileName = uniqid('qrcode_', true) . '.png';
        $filePath = \dirname(__DIR__, 2) . '/public/images/qrCode/' . $fileName;

        // Sauvegarder le fichier PNG
        $result->saveToFile($filePath);

        return $fileName; // Retourner le chemin du fichier généré
    
    }
}
