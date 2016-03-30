#!/usr/bin/python

import dpkt

counter=0
ipcounter=0
arpcounter=0

tcpcounter=0
icmpcounter=0
dhcpcounter=0
httpcounter=0
dnscounter=0
telnetcounter=0
smtpcounter=0
ftpcounter=0

udpcounter=0
dhcpcounter=0
snmpcounter=0
tftpcounter=0
ntpcounter=0
sipcounter=0
unkwcounter=0




filename='test.pcap'

for ts, pkt in dpkt.pcap.Reader(open(filename,'r')):

    counter+=1

    eth=dpkt.ethernet.Ethernet(pkt)

    if eth.type!=dpkt.ethernet.ETH_TYPE_IP:
        continue
    elif eth.type!=dpkt.ethernet.ETH_TYPE_ARP:
        continue

    ip=eth.data
    ipcounter+=1

    if ip.p==dpkt.ip.IP_PROTO_TCP:
        tcpcounter+=1
        if tcp.dport == 80:
            httpcounter+=1
        elif tcp.dport == 443:
            httpscounter+=1
        elif tcp.dport == 53:
            dnscounter+=1
        elif tcp.dport == 23:
            telnetcounter+=1
        elif tcp.dport == 20 or 21:
            ftpcounter+=1
        elif tcp.dport == 25:
            smtpcounter+=1

    if ip.p==dpkt.ip.IP_PROTO_UDP:
        udpcounter+=1
        if udp.dport == 546:
            dhcpcounter+=1
        elif udp.dport == 161:
            snmpcounter +=1
        elif udp.dport == 69:
            tftpcounter+=1
        elif udp.dport == 123:
            ntpcounter+=1
        elif udp.dport == 5060:
            sipcounter+=1


    if ip.p==dpkt.ip.IP_PROTO_ICMP:
        icmpcounter+=1


    #if ip.p==dpkt.ip.IP_PROTO_ARP:
    #    arpcounter+=1

    #if ip.p==dpkt.ip.IP_PROTO_DHCP:
    #    dhcpcounter+=1

    else:
      unkwcounter+=1


print ("Nombre total de paquets dans le fichier", counter)
print ("Nombre total de paquets IP ", ipcounter)
print ("Nombre total de paquets ARP", arpcounter)
print ("Nombre total de paquets TCP ", tcpcounter)
print ("Nombre total de paquets UDP ", udpcounter)
print ("Nombre total de paquets ICMP :", icmpcounter)
print ("Nombre total de paquets ARP :", arpcounter)
print ("Nombre total de paquets DHCP :", dhcpcounter)
print ("Nombre total de paquets HTTP :", httpcounter)