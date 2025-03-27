# Spider-Snare

## A simple loop-hole for web-spiders and crawlers

### Declaration of Intent

This software was designed and developed for **educational purposes** only.  
The author **assumes no responsibility** for any damage caused by the **improper** use of this software.  

### Usage Limits and Restrictions

This software should only be used in **safe testing environments**, such as isolated virtual machines, and **should never be run on real systems or on a public network**.  
Use of this software in unauthorized environments or for malicious purposes is **strictly prohibited**.

### Introduction

The project aims to emulate a simple loop-hole for web-spiders and crawlers by generating unique **pages** and **links** interconnected in a **limitless loop**.  
For each request the engine generates **unique content** that is than **slowly** streamed back to the client in order to keep the crawler (or any not-so-intelligent visitor) **busy** for as long as possible.  
When a web-spider or a crawler ends up in the trap they are potentially **blocked forever**, or at least until they realize the deception and **stop browsing**.  

**ATTENTION!**  
As mentioned in the **Declaration of Intent** this software was designed and developed for **educational purposes** only.  
The author **assumes no responsibility** for any damage caused by the **improper** use of this software.

### Requirements

- *nix Operating System, such as [Ubuntu](https://www.ubuntu-it.org/), [Debian](https://www.debian.org/index.it.html) or [MacOS](https://www.apple.com/it/mac/)
- Bash or any other shell and `sudo` privileges.
- [Docker Engine](https://docs.docker.com/engine/)
- [Docker Compose](https://docs.docker.com/compose/)

### Installation

The software is based on [Docker](https://www.docker.com/) containers to run an [Apache](https://httpd.apache.org/) web server instance.  
[Docker](https://www.docker.com/) services need to always be up and running.

- Download and extract the source code
- Enter the project directory
- Run `sudo (?) docker compose up -d --build` and wait for the process to finish
- Visit [localhost](http://localhost:8080/) and enjoy!

### Notes and Conclusions

The web contents and links are generated based on the `/corpus/corpus.csv` source file.  
You can edit the source entries **manually** or **generate new entries** by following these steps:

- Visit [Mockaroo](https://www.mockaroo.com/)
- Configure the export template colums as follows:
  - name: "Buzzword"
  - description: "Catch Phrase"
  - path: "Url" (only path)
- Run the standard CSV export

If you need to **remove file extensions** on a newly generated corpus run the following command:  
`sed -E 's/\.[a-zA-Z0-9]+//g' ./corpus/MOCK_DATA.csv > ./corpus/corpus.csv`
