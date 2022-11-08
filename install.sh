#!/bin/bash
docker kill bigbluebutton-demo &> /dev/null
docker rm bigbluebutton-demo &> /dev/null

docker build -t bigbluebutton-demo .
