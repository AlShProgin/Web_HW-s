#!/usr/bin/bash
  # It is expected that the environment variable the script accesses is a file
  # extension passed in a form of ".<extension>"

  # Additionally, since the script does not use regular expressions to extract
  # an extension from the file name passed as a parameter, there is no point in it
  # is's just there
  # A command used for testing: export $test_var=.txt
  #                             ./script_2.sh file3.txt

  # step 1: assigning the parameter to variable "fileName"
  #         echoing both the parameter and the env.var in the terminal
fileName=$1
echo "Accessing an environment variable $test_var"
echo "Received a parameter: $fileName"
  # step 2: using the given extension to find all files of specified extension
  #         and to determine their types
temp=$(find . -type f -name "*$test_var")
echo $(file $temp)
exit 0