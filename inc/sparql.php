<?php

function country_iso3($country){

  $codes = [
    "mekong" => '("KHM","THA","LAO", "MMR", "VNM")',
    "thailand" => '("THA")',
    "laos" => '("LAO")',
    "vietnam" => '("VNM")',
    "myanmar" => '("MMR")',
  ];

  $iso3 = $codes[$country];

  return iso3;

}

?>
