<?php
/*
 * This file is part of the project by AGBOKOUDJO Franck.
 *
 * (c) AGBOKOUDJO Franck <franckagbokoudjo301@gmail.com>
 * Phone: +229 0167 25 18 86
 * LinkedIn: https://www.linkedin.com/in/internationales-web-services-120520193/
 * Github: https://github.com/Agbokoudjo/norldfinance.com
 * Company: INTERNATIONALES WEB SERVICES
 *
 * For more information, please feel free to contact the author.
 */

namespace App\Infrastructure\Services;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @author AGBOKOUDJO Franck <franckagbokoudjo301@gmail.com>
 * @package <https://github.com/Agbokoudjo/norldfinance.com>
 */
final class ProcessUploadedFiles 
{
    public function __construct(
        private readonly Filesystem $filesystem,
        private readonly ParameterBagInterface $services
        ){}
    /**
     * Undocumented function
     *
     * @param array<string,UploadedFile> $uploadedFiles
     * @return array<string,string>
     */
    public function uploadFiles(array $uploadedFiles):array{
        $tempDir=$this->services->get('kernel.project_dir') 
        . DIRECTORY_SEPARATOR .'public'. DIRECTORY_SEPARATOR.'temp_upload_';
        try {
            $this->filesystem->mkdir($tempDir,0775);
        } catch (IOException $e) {
            throw new \RuntimeException(
                sprintf('Échec de la création du répertoire temporaire "%s" : %s', $tempDir, $e->getMessage()),
                0,
                $e
            );
        }
        $fileNames = [];

        /** @var UploadedFile $uploadedFile 
         * @var string $type =image or document
        */
        foreach ($uploadedFiles as $type=> $uploadedFile) {
            $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = $originalFilename . '-' . uniqid() . '.' . $uploadedFile->guessExtension();
            $uploadedFile->move($tempDir, $newFilename);
            $fileNames[$type] = $tempDir . DIRECTORY_SEPARATOR . $newFilename;
        }
        return $fileNames ;
    }
    public function removeFiles(array $filesPath):void{
        foreach($filesPath as $file_as_remove){
            if($this->filesystem->exists($file_as_remove)){$this->filesystem->remove($file_as_remove);}
        }
    }
}
