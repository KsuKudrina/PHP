<?php

function deleteUser(array $config): string
{
    $address = $config['storage']['address'];

    $data = readline("Кого удаляем? Введите имя или дату рождения в формате ДД-ММ-ГГГГ: ");
    $newData = '';
    $flag = false;
    if (file_exists($address) && is_readable($address)) {
        $file = fopen($address, "rb");
        while (!feof($file)) {
            $contents = fgets($file, 100);
            if (str_contains($contents, $data)) {
                $flag = true;
            } else {
                $newData .= $contents;
            }
        }
        if (!$flag && feof($file)) {
            return "- \r\n Ничего не найдено \r\n-";
        }
        $fileHandler = fopen($address, 'w');
        if (fwrite($fileHandler, $newData)) {
            return "- \r\n Удаление завершено \r\n-";
        } else {
            return handleError("- \r\n Произошла ошибка записи. Данные не сохранены \r\n-");
        }
    } else {
        return handleError("Файл не существует");
    }
}
