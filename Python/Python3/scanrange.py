#!/usr/bin/python3

###
# Import lib
###
import argparse
import subprocess

###
# Parsing Options
###

parser = argparse.ArgumentParser(description='How to use this script')
parser.add_argument('-d',
    action='store_true',
    help='Enable Debug mod' )

args = parser.parse_args()


###
# Variables
###
network="192.168.1."
host=252
host_up=0
list_host=[]

###
# Script Start
###
print("[INFO] Scan: START")
if args.d:
    print("[DEBUG] Network: ", network)

while host < 255:
    try:
        ip=str(network) + str(host)
        if args.d:
            print("[DEBUG] Ip:", ip)

    except TypeError as err:
        print("[CRIT] Error while creating IP variable.")
        if args.d:
            print("[DEBUG]",err)
        exit(2)
    except:
        print("[CRIT] Something went wrong ...")
        exit(2)

    print("[INFO] Scan IP ", ip)

    cmd = "ping -c 1 " + str(ip)
    if args.d:
        print("[DEBUG] Cmd: ",cmd)
    ping = subprocess.getstatusoutput(cmd)

    if args.d:
        print("[DEBUG] Retour commande:", ping[1])

    if ping[0] == 0:
        list_host.append(str(ip))
        host_up += 1

    elif ping[0] == 2:
        print("[CRIT] Something went wrong...")
        if args.d:
            print("[DEBUG]", ping[1])
        exit(2)

    host += 1

print("[INFO] Scan: FINISH")
print("[INFO] Number of host UP in your network: ", host_up)
if host_up >= 1:
    print("[INFO] List: ")

    for host in list_host:
        print("[INFO]\t\t- ", host,"is UP")