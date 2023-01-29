<?php

namespace App\Services;

use Smalot\PdfParser\Parser;

class Extractor
{
    public function extract($path, $invoice_store)
    {
        if ($invoice_store == "tokopedia") {
            return $this->tokopediaExtractPdf($path);
        } elseif ($invoice_store == "shoppe") {
            return $this->shopeeExtractPdf();
        } elseif ($invoice_store == "lazada") {
            return $this->lazadaExtractPdf();
        } elseif ($invoice_store == "tiktok") {
            return $this->tiktokExtractPdf();
        }
    }

    public function tokopediaExtractPdf($path)
    {
        $parser = new Parser();
        $pdf = $parser->parseFile($path);
        $pdfText = $pdf->getText();
        $pdfText = nl2br($pdfText);
        $pdfText = str_replace(" ", "", $pdfText);
        $pdfTextArr = explode("\n", $pdfText);

        if (count($pdfTextArr) > 0) {
            return $pdfTextArr[0];
        }
        return [];
    }
    public function shopeeExtractPdf()
    {
    }
    public function lazadaExtractPdf()
    {
    }
    public function tiktokExtractPdf()
    {
    }

    public function getFiles()
    {
        return $_FILES['invoice_file'] ?? [];
    }

    public function setFileUpload($data)
    {
        $_FILES['invoice_file'] =  $data;
        return $this;
    }

    public function getFile($key = '')
    {
        if ($key) {
            return $_FILES['invoice_file'][$key] ?? [];
        }

        return $_FILES['invoice_file'];
    }

    public function upload($upload, $data = [])
    {
        $files = $this->getFiles();
        unset($_FILES['invoice_file']);
        $i = 0;
        foreach ($files['name'] ?? [] as $key => $file) {

            $this->setFileUpload([
                'name' => $files['name'][$i],
                'full_path' => $files['full_path'][$i],
                'tmp_name' => $files['tmp_name'][$i],
                'error' => $files['error'][$i],
                'size' => $files['size'][$i],
                'type' => $files['type'][$i],
            ]);

            if ($upload->do_upload('invoice_file')) {
                $filename = $upload->data('file_name');
                $filepath = $upload->data('file_path');


                $data['invoice'] = $this->getFile('name');
                $data['no_invoice'] = $this->extract("{$filepath}{$filename}", $_POST['invoice_store'] ?? '');
                $this->save($data);
            } else {
                echo $upload->display_errors();
            }
            $i++;
        }

        return $this;
    }


    public function save($data)
    {
        $paket = new \App\Models\Paket;
        return $paket->create($data);
    }
}
