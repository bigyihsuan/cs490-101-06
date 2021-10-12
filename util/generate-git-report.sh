#!/bin/bash

authors=("Nova" "bigyihsuan" "pbp38")
for author in ${authors[@]}; do
    echo $author
    git show `git log --author=$author | grep ^commit | awk -F ' ' '{print $2}'` > $author.txt
done