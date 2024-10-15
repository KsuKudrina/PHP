<?php


function dateSearch(array $config)
{
    $address = $config['storage']['address'];

    $users = [];
    if (file_exists($address) && is_readable($address)) {
        $file = fopen($address, 'rb');
    }
    while (!feof($file)) {
        $user = fgets($file);
        $userArray = explode(',', $user);


        if (isset($userArray[1])) {
            $dateData = explode('-', trim($userArray[1]));
            if (($dateData[0] >= date('d')  ||
                    $dateData[1] < date('d') + 5) &&
                $dateData[1] == date('m')
            ) {
                $users[] = $userArray[0];
            }
        }
    }
    $result = '';
    if (empty($users)) {
        $result = "Именинников в ближайшие 5 дней НЕТ!";
    } else {
        $result = "Именинники в ближайшие 5 дней: " . PHP_EOL;
        foreach ($users as $user) {
            $result .= $user . PHP_EOL;
        }
    }
    return $result;
}
