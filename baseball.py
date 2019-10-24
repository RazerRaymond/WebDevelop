import sys
import os
import re
    #File input and Usage Message
if len(sys.argv) < 2:
    sys.exit(f"Usage: {sys.argv[0]} need a file route to run.")

filename = sys.argv[1]

if not os.path.exists(filename):
    sys.exit(f"Error: File '{sys.argv[1]}' was not found.")

file = open(filename, "r")
    #make a dictionary to save stats and use a list to sort outcome
pInfo = dict()
res = list()
    # set a regex pattern
pat = "^([a-zA-Z-]+\s[a-zA-Z-]+)\sbatted\s(\d)\stimes\swith\s(\d)\shits\sand\s(\d)\sruns$"


# class Player:
#     def __init__(self, name, times, hits, runs):
#         self.name = name
#         self.times = times
#         self.hits = hits
#         self.runs = runs
# 
#     def getAvg(self):
#         return float(hits / times)

#Find method to check doc and group certain result, putting them in the preset dictionary
def find(x, y):

    if re.match(x, y):
        name = re.match(x, y).group(1)
        bCount = int(re.match(x, y).group(2))
        hCount = int(re.match(x, y).group(3))
        rCount = int(re.match(x, y).group(4))
        # player = Player(name, bCount, hCount, rCount)
        if name != "":
            if name in pInfo:
                pInfo[name]['bCount'] += bCount
                pInfo[name]['hCount'] += hCount
            else:
                pInfo[name] = {'bCount': bCount, 'hCount': hCount }

# check the whole file
for line in file:
    find(pat, line)
# close the file and same memory
file.close()
#computing the avg and add results to res list
for name in pInfo:
    avg = float(pInfo[name]['hCount'] / pInfo[name]['bCount'])
    res.append((name, avg))
# sort and print rounded results
res.sort(key=lambda x: x[1], reverse=True)
for i in res:
    print("{}: {:.3f}".format(i[0],round(i[1],3)))
