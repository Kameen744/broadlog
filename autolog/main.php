<?php
  spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
  });

  function processFiles() {
    $database = new Database();
    $filepath = "C:\Users\kamee\OneDrive\Documents\VirtualDJ\History";
    $files = new FilesystemIterator($filepath, FilesystemIterator::UNIX_PATHS);
    
    $date_played = null;
    foreach ($files as $file) {
      if($file->getExtension() === 'txt'){
      $open = $file->openFile('r+');
      $open->setFlags(SplFileObject::SKIP_EMPTY | SplFileObject::READ_CSV | SplFileObject::DROP_NEW_LINE);
        foreach ($open as $line) {
          if(isset($line[0])) {
            $cLine = preg_replace('/[^A-Za-z0-9:\ ]/', '-', $line[0]);
            if(strpos($cLine, 'VirtualDJ History') !== false) {
              
              $date_played = new DateTime(substr($cLine, -10));
              $date_played = $date_played->format('Y-m-d');

            } elseif($cLine != '------------------------------') {
              
              $time_played = substr($cLine, 0, 5);
              $file_played = trim(substr($cLine, +8));

              $ins = $database->insertRow(
                'INSERT INTO test_table (file_name, date_played, time_played) VALUES (?, ?, ?)', 
                [$file_played, $date_played, $time_played]
              ); 
              // print_r(' '. $ins .' ');
            }
          }
        }
        $file->openFile('w', '');
      }
    }
  }

  while(true) {
    processFiles();
    sleep(120);
  }