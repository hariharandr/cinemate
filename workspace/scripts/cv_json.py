import csv
import json
import os
import glob

def tsv_to_json(tsv_directory, json_directory):
    # Find all TSV files in the specified directory
    tsv_files = glob.glob(os.path.join(tsv_directory, '*.tsv'))
    
    for tsv_filepath in tsv_files:
        # Construct JSON file path based on TSV file name
        json_filename = os.path.splitext(os.path.basename(tsv_filepath))[0] + '.json'
        json_filepath = os.path.join(json_directory, json_filename)
        
        # Open the TSV file
        with open(tsv_filepath, 'r', encoding='utf-8') as file:
            tsv_reader = csv.DictReader(file, delimiter='\t')
            
            # Open the JSON file for writing
            with open(json_filepath, 'w', encoding='utf-8') as jsonf:
                for row in tsv_reader:
                    # Convert any '\N' in the data to None (or null in JSON)
                    row = {key: (None if value == '\\N' else value) for key, value in row.items()}
                    jsonf.write(json.dumps(row) + '\n')

tsv_to_json('/home/Jawahar.s/htdocs/cinemate/workspace/imdb_datasets', '/home/Jawahar.s/htdocs/cinemate/workspace/imdb_datasets')
