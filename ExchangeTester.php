<?php
/**
 * Компонент для тестирования обмена данными 1С 8 с сайтом
 * @class ExchangeTester
 * @link http://v8.1c.ru/edi/edi_stnd/131/
 */
class ExchangeTester
{

    /**
     * @var string  базовый урл скрипта обмена данными на сайте
    */
    private $baseUrl = 'http://url_to_test';

    /**
     * @var string имя пользователя для аутентификации
    */
    private $userName = 'username';

    /**
     * @var string пароль пользователя для аутентификации
    */
    private $password = 'password';

    /**
     * @var string   путь к файлу, в котором будут храниться куки во время теста
    */
    private $cookieFile = 'data/cookie.txt';

    /**
     * @var string  файл с данными, которые будут отправляться на сайт (архив должен содержать 2 файла import.xml, offers.xml)
    */
    private $dataFile = 'data/data.zip';


    public function __construct($config = array())
    {
        foreach ($config as $configName => $configValue) {
            $this->{$configName} = $configValue;
        }
    }


    public function testSession()
    {
        set_time_limit(0);

        echo "Test auth: \n" . $this->testAuth() . "\n\n";
        echo "Test init: \n" . $this->testInit() . "\n\n";
        echo "Test file: \n" . $this->testFile() . "\n\n";
        echo "Test import file: \n" . $this->testImportFile('import.xml') . "\n\n";
        echo "Test offers file: \n" . $this->testImportFile('offers.xml') . "\n\n";
    }


    private function testAuth()
    {
        $url = "{$this->baseUrl}?type=catalog&mode=checkauth&testmode=true";
        $credentials = "{$this->userName}:{$this->password}";
        $ch = curl_init($url);
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
            CURLOPT_USERPWD => $credentials,
            CURLOPT_COOKIEJAR => $this->cookieFile,
        ));

        return curl_exec($ch);
    }


    private function testInit()
    {
        $url = "{$this->baseUrl}?type=catalog&mode=init&testmode=true";
        $ch = curl_init($url);
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_COOKIEFILE => $this->cookieFile,
        ));
        return curl_exec($ch);
    }


    private function testFile()
    {
        $filePath = realpath($this->dataFile);
        $fileName = pathinfo($filePath, PATHINFO_BASENAME);
        $url = "{$this->baseUrl}?type=catalog&mode=file&filename={$fileName}&testmode=true";

        $fp = fopen($filePath, 'r');
        $ch = curl_init($url);
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_COOKIEFILE => $this->cookieFile,
            CURLOPT_INFILE => $fp,
            CURLOPT_INFILESIZE => filesize($filePath),
            CURLOPT_PUT => 1,
            CURLOPT_UPLOAD => 1,
        ));
        $result = curl_exec($ch);
        fclose($fp);
        return $result;
    }


    private function testImportFile($fileName = 'import.xml')
    {
        $url = "{$this->baseUrl}?type=catalog&mode=import&filename={$fileName}&testmode=true";
        $ch = curl_init($url);
        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_COOKIEFILE => $this->cookieFile,
        ));
        return curl_exec($ch);
    }

}

