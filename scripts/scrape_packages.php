<?php

use SlimRunner\AppConfig as AppConfig;

require_once 'script_bootstrap.php';
$packages = $db->loadModel('Packages');
$genresDb = $db->loadModel('Genres');

$content = CurlCaller::call('GET', DSTVUrls::getPackages());

$genreIndex = explode('|', AppConfig::get('channels', 'indexlist'));

if (!empty($content)) {
    $content = json_decode($content, TRUE);

    foreach ($content['items'] as $packageInfo)
    {
        $existingPackage = $packages->getRow('packagecode', $packageInfo['ProductCode']);

        if (empty($existingPackage)) {
            $packages->add([
                'packageid' => $packageInfo['Id'],
                'title' => $packageInfo['Title'],
                'packagecode' => $packageInfo['ProductCode'],
            ]);
        } else {
            $packages->update($existingPackage['id'], [
                'packageid' => $packageInfo['Id'],
                'title' => $packageInfo['Title'],
            ]);
        }

        if ($packageInfo['ProductCode'] == 'PRM') {
            var_dump($packageInfo['Genres']);
            var_dump($genreIndex);

            foreach ($packageInfo['Genres'] as $genre)
            {

                \
                var_dump($genre);

                $existingGenre = $genresDb->getRow('name', $genre['name']);

                if (empty($existingGenre)) {
                    $genresDb->add([
                        'genreid' => $genre['id'],
                        'name' => $genre['name'],
                        'canindex' => in_array($genre['name'], $genreIndex) ? 'Y' : 'N',
                    ]);
                } else {
                    $genresDb->update($existingGenre['id'], [
                        'genreid' => $genre['id'],
                        'name' => $genre['name'],
                        'canindex' => in_array($genre['name'], $genreIndex) ? 'Y' : 'N',
                    ]);
                }
            }

        }

    }
}