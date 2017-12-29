<?php
use Illuminate\Database\Seeder;

class CsvTableSeeder extends Seeder 
{
    
  public function run()
  {
         function csv_to_array($filename='', $delimiter=',')
        {
            if(!file_exists($filename) || !is_readable($filename))
                return FALSE;

            $header = NULL;
            $data = array();
            if (($handle = fopen($filename, 'r')) !== FALSE)
            {
                while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
                {
                    if(!$header)
                        $header = $row;
                    else
                        $data[] = array_combine($header, $row);
                }
                fclose($handle);
            }
            return $data;
        }
      
        $csvFile = database_path(). '\csv\mutations.csv';
        $areas = csv_to_array($csvFile);
        DB::table('mutations')->insert($areas);
      
        $csvFile = database_path(). '\csv\versions.csv';
        $areas = csv_to_array($csvFile);
        DB::table('versions')->insert($areas);
        
        $csvFile = database_path(). '\csv\user_version.csv';
        $areas = csv_to_array($csvFile);
        DB::table('user_version')->insert($areas);
  }
}