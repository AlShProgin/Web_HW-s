#!/usr/bin/bash
# it is implied that the script receives 5 parameters upon being called:
# 1: number of lines to copy from the end of the 1st file
# 2: number of lines to copy from the beginning of the 2nd file
# 3: a pattern to replace
# 4: a pattern replacing the one in #3
# 5: number of lines containing the specified pattern to be copied to file3 (with the new pattern)
# Additionally, the script does not check the parameters for invalid data
# intendedvalues of the parameters: 10, 7, linux, windows, 2
# The final view of a command to run the script: ./script_1.sh 10 7 linux windows 2

scriptName=$0
linesTail=$1
linesHead=$2
patternOld=$3
patternNew=$4
entriesToCopy=$5

  # step 0: echoing an initial message with the script's name
echo "Running a script $scriptName"
echo "The received parameters are: $linesTail, $linesHead, $patternOld, $patternNew, $entriesToCopy
numOfLines=$(cat file1.txt|wc -l)
echo "File1 contains $numOfLines lines"
  # step 1: copying the specified number of last lines from file1 to file2
tail -n $linesTail file1.txt > file2.txt
echo "The script has copied last $linesTail lines from file1 to file2
  # step 2: copying the specified number of first lines from file2 to file3
head -n $linesHead file2.txt > file3.txt
echo "The script has copied first $linesHead lines from file2 to file3"
  # step 3: replace the specified pattern in file2 by the new one
  #         and copy the first 2 entries to file3
grep "linux" file2.txt|sed "s/linux/windows/g"|head -n 2 > file3.txt
echo "Copied linex containing the pattern to file3"
  # step 4: lave only unique lines in file3 and display the number of pre-existing duplicates
temp=$(sort file3.txt|uniq -c)
echo $temp > file3.txt
echo "Left only unique lines in file3 with a number of previous dublicates"
exit 0