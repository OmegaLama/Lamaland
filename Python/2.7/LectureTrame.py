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

# For each packet in the pcap process the contents
for timestamp, buf in dpkt.pcap.Reader(open(filename,'r')):

    # Print out the timestamp in UTC
    print 'Timestamp: ', str(datetime.datetime.utcfromtimestamp(timestamp))

    # Unpack the Ethernet frame (mac src/dst, ethertype)
    eth = dpkt.ethernet.Ethernet(buf)
    print 'Ethernet Frame: ', mac_addr(eth.src), mac_addr(eth.dst), eth.type

    # Make sure the Ethernet frame contains an IP packet
    # EtherType (IP, ARP, PPPoE, IP6... see http://en.wikipedia.org/wiki/EtherType)
    if eth.type != dpkt.ethernet.ETH_TYPE_IP:
        print 'Non IP Packet type not supported %s\n' % eth.data.__class__.__name__
        continue

    # Now unpack the data within the Ethernet frame (the IP packet)
    # Pulling out src, dst, length, fragment info, TTL, and Protocol
    ip = eth.data

    # Pull out fragment information (flags and offset all packed into off field, so use bitmasks)
    do_not_fragment = bool(ip.off & dpkt.ip.IP_DF)
    more_fragments = bool(ip.off & dpkt.ip.IP_MF)
    fragment_offset = ip.off & dpkt.ip.IP_OFFMASK

    # Print out the info
    print 'IP: %s -> %s   (len=%d ttl=%d DF=%d MF=%d offset=%d)\n' % \
          (ip_to_str(ip.src), ip_to_str(ip.dst), ip.len, ip.ttl, do_not_fragment, more_fragments, fragment_offset)