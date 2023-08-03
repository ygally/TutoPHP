<?php
    function fix_corrupted_csv($corrupted_csv_file, $backup_file, $output_file) {
        // Step 1: Read the corrupted CSV file into one single string
        $contents = file_get_contents($corrupted_csv_file);
        
        // Step 2: Create a backup of the original CSV file
        copy($corrupted_csv_file, $backup_file);
        
        // Step 3: Clean up and format the data
        // Remove <p> tags, and immediately following line returns
        $contents = str_replace(["<p>", "</p>\n"], '', $contents);
        
        // Step 4: Write the cleaned data to a new valid CSV file
        file_put_contents($output_file, $contents);
    }
    
    function main() {
        $corrupted_csv_file = readline('file path : ');
        $work_file = "work/" . basename($corrupted_csv_file);
        if (copy($corrupted_csv_file, $work_file)) {
            $backup_file = $work_file . '.backup' . date('Ymd.His');
            $cleaned_file = str_replace('.csv', '.cleaned.csv', $work_file);
            
            echo "Processing file ... [ {$work_file} -> {$backup_file} -> {$cleaned_file} ]\n\n";
            
            fix_corrupted_csv($work_file, $backup_file, $cleaned_file);
        }
    }
    
    echo "Starting...\n\n";
    
    main();

    echo "\n\nEnded!\n";