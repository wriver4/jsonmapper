<?php
class Address
{
    public $street;
    public $city;

    public function getGeoCoords()
    {
        $url = 'https://nominatim.openstreetmap.org/search?q='
            . urlencode($this->street)
            . ',' . urlencode($this->city)
            . '&format=json&addressdetails=1';

        $context = stream_context_create(array(
            'http' => array(
                'header' => 'User-Agent: JsonMapper-Example/1.0'
            )
        ));

        $data = @file_get_contents($url, false, $context);
        if ($data === false) {
            throw new Exception('Failed to fetch geocoding data from API');
        }

        $json = json_decode($data);
        if ($json === null || !is_array($json) || empty($json)) {
            throw new Exception('Invalid or empty response from geocoding API');
        }

        if (!isset($json[0]->lat) || !isset($json[0]->lon)) {
            throw new Exception('Geocoding response missing lat/lon data');
        }

        return array(
            'lat' => $json[0]->lat,
            'lon' => $json[0]->lon
        );
    }
}
?>
