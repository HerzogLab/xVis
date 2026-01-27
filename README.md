# xVis

## Visualizing crosslinking data for protein complexes

xVis is a software tool designed to visualize distance restraints from chemical crosslinking experiments. It generates clear schematic representations of protein complex structures in circular, bar, and network plots. xVis supports crosslink data from xQuest and other compatible formats, and allows inspection of mass spectrometric data.

### Features
- Circular, bar, and network plots of protein complexes
- Visualizes inter- and intra-protein crosslinks
- Supports UniProt IDs, FASTA headers, or user-defined protein names
- Import of user-defined or InterPro protein annotations
- Filter crosslinks by score or false discovery rate
- View fragment ion spectra (requires xQuest connection)

### Quick Start
Web Server Installation
To run xVis on a web server:
Make sure your server supports PHP. Download PHPif needed.
Extract the xVis source files and copy them into your server directory.
Optional: To run without user accounts, delete xVis/user/test_user.
To use user accounts, log in as test_user, then create a new admin user and delete test_user.
xVis will then be accessible via [server_address]/xVis.

Local Installation (Windows only)
If you don’t have a web server, you can use the XAMPP package included:
Extract the zip and copy the xampp folder to your destination folder.
Run xampp/setup_xampp and approve the command-line application.
Run xampp/apache_start each time to start the server.
Follow the Web Server Installation steps above.
Recommended: adjust security settings at http://localhost/security/index.php
 if accessing via the internet.
xVis will be accessible at http://localhost/xVis.

### Input Data
xVis requires at minimum a crosslink data file (CSV) with columns:
`Protein1, Protein2, AbsPos1, AbsPos2`

Optional files for additional features:
Protein lengths (Protein, Length)
Domain annotations (Protein, Start, End, Name)
Score/FDR columns for filtering

See the full manual for details on file formats and display options.


### License
This project’s content (manuals, documentation, example data) is licensed under the Creative Commons Attribution 4.0 International License (CC BY 4.0). See [LICENSE](LICENSE) for details.

### Contact
Franz Herzog - herzog@genzentrum.lmu.de
