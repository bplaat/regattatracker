#! /usr/bin/python

import argparse
import sys
import ais as ai
import requests as rq
import json

#Function used to print every mmsi number from all the messages received, stopping if you get a new message from the same sender as the first.
def getAllMMSI(ser):
    mmsiList = list()
    firstData = ser.read_serial()
    firstDataDecoded = decode_ais(firstData)
    mmsiList.append(firstDataDecoded["mmsi"])
    while(True):
        data = ser.read_serial()
        decodedData = decode_ais(data)
        try:
            if decodedData["mmsi"] == firstDataDecoded["mmsi"]:
                break
            mmsiList.append(decodedData["mmsi"])
        except Exception:
            pass
    return mmsiList
    
#Function used to decode and format an nmea message into a dictionary
def decode_ais(message):
    try:
        ais_data = ai.decod_ais(message)
        ais_format = ai.format_ais(ais_data)
        return ais_format
    except Exception as e:
        pass
    return None

def main(giveMMSI):
    #Open serial GPIO port.
    serial = ai.AISserial('/dev/ttyAMA0')
    
    #Url to the webserver and an api key generated on that server.
    webserverURL = 'https://test.regattatracker.nl/api/ais'
    webserverAPIKey = 'c599f3d56a11b89130c060628a33e726'
    
    if giveMMSI:
        print("Getting mmsi numbers... Please wait.")
        print("------------------------------------")
        for mmsi in getAllMMSI(ser):
            print(mmsi)
        print("------------------------------------")
    
    while(True):
        #Read one message from the serial port and give back the nmea message.
        #Example nmea message: !AIVDM,1,1,,B,13`fal0P010CQ;LMksnf4?v42<52,0*05
        data = ai.read_serial() 
        
        #Decode the nmea message into readable text, put this text into a dictionary.
        decodedData = decode_ais(data)
        
        #Form a json string from the dictionary for ease of use
        dataString = json.dumps(decodedData)
        
        #Send the json string to the webserver, you need an api key for this to work without authentication.
        req = rq.post(webserverURL, data = {'api_key': webserverAPIKey, 'data': dataString})

if __name__ == "__main__":
    parser = argparse.ArgumentParser(description = 'AIS Receiver')
    parser.add_argument('--mmsi', default=False, type = bool, metavar = 'MMSI', help = "Set to true if you want to see possible mmsi numbers")
    args = parser.parse_args(sys.argv[1:])
    giveMMSI = args.mmsi
    main(giveMMSI)



