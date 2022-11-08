# BigBlueButton demo

This is a simple docker container that can be used to demonstrate a running BigBlueButton server.

# Setup

If you got a BigBlueButton server with greenlight, and want to replace by this simpler demo, you can follow these steps:

 - `docker kill greenlight-v2 greenlight_db_1`
 - `docker rm greenlight-v2 greenlight_db_1`
 - `git clone https://github.com/iMDT/bigbluebutton-demo.git`
 - `cd bigbluebutton-demo`
 - `./install.sh`
 - `./start.sh`
