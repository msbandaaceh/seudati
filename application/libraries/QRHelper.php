<?php
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;

defined('BASEPATH') OR exit('No direct script access allowed');

class QRHelper {

    public function create($link, $logoPath = null)
    {
        $builder = Builder::create()
            ->writer(new PngWriter())
            ->data($link)
            ->encoding(new Encoding('UTF-8'))
            ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
            ->size(240)
            ->margin(10);

        if ($logoPath && file_exists($logoPath)) {
            $builder->logoPath($logoPath)
                    ->logoResizeToWidth(48);
        }

        $result = $builder->build();
        return $result->getDataUri();
    }
}