# SpiderSnare

## Corpus Data - Download

- Visit [Mockaroo](https://www.mockaroo.com/).
- Configure the export template colums as follows:
  - name: Buzzword
  - description: Catch Phrase
  - path: url (only path)
- Run the standard CSV export (1k rows).

## Corpus Data - Formatting

- Move the downloaded export file inside the project `corpus` directory.
- Run `sed -E 's/\.[a-zA-Z0-9]+//g' ./corpus/MOCK_DATA.csv > ./corpus/corpus.csv`.
- The formatted `corpus.csv` file will now be automatically queued.

