#!/bin/bash

# usage:
#     bash util/generate-git-report.sh report-location
# outputs your changes to a .txt file
# submit that with your submission

authors=("Nova" "bigyihsuan" "pbp38")
for author in "${authors[@]}"; do
    echo "$author"
    rm "$author.txt"
    echo "$author.txt removed"
    git show $(git log --author="$author" | grep ^commit | awk -F ' ' '{print $2}') >"$author.txt"
done
