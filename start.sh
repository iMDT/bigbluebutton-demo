#!/bin/bash
BIGBLUEBUTTON_URL=$(bbb-conf --salt | grep 'URL:' | head -n 1 | awk -F 'URL:' '{print $2}' | xargs -n 1 echo -n)
BIGBLUEBUTTON_SECRET=$(bbb-conf --salt | grep 'Secret:' | head -n 1 | awk -F 'Secret:' '{print $2}' | xargs -n 1 echo -n)

BIGBLUEBUTTON_URL="$BIGBLUEBUTTON_URL"
BIGBLUEBUTTON_SECRET="$BIGBLUEBUTTON_SECRET"

docker run --name bigbluebutton-demo -d -p127.0.0.1:5000:80 -e BIGBLUEBUTTON_URL="$BIGBLUEBUTTON_URL" -e BIGBLUEBUTTON_SECRET="$BIGBLUEBUTTON_SECRET"  bigbluebutton-demo
