#!/bin/bash

# usage: (assuming root project dir)
# bash util/generate-git-report.sh
# outputs your changes to a .txt file
# submit that with your submission

authors=("Nova" "bigyihsuan" "pbp38")
for author in "${authors[@]}"; do
    echo "$author"
    git show "$(git log --author=$author | grep ^commit | awk -F ' ' '{print $2}')" >"$author.txt"
done
