#!/bin/bash
export DEBIAN_FRONTEND=noninteractive
export LC_ALL=en_US.UTF-8
export LANG=en_US.UTF-8

# sudo aptitude --help
# -y             Assume that the answer to simple yes/no questions is 'yes'.
# -f             Aggressively try to fix broken packages.
# -q             In command-line mode, suppress the incremental progress indicators.
sudo aptitude update -q