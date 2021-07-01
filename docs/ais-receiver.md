[&laquo; Back to the README.md](../README.md)

# AIS Reciver Documentatie
Om de boten te kunnen tracken op de website heb je een raspberry pi met een AIS receiver nodig. Op deze pagina zullen we uitleggen hoe dat in zijn werking gaat.

## Python client code

[Link naar de client code](../ais-receiver/ais-receiver.py)  
=======
In de client code hebben we gebruik gemaakt van een library waarin we een NMEA message om zetten naar een leesbare python dictionary.  
Om de message om te zetten moet hij eerst gedecode worden waarna hij geformat word in een dictionary.
```python
def decode_ais(message):
    try:
        ais_data = ai.decod_ais(message)
        ais_format = ai.format_ais(ais_data)
        return ais_format
    except Exception as e:
        pass
    return None
```
Om een message te kunnen ontvangen op de raspberry pi gebruiken we een hat (hierover meer in het kopje hardware).
Deze head maakt gebruik van de GPIO serial port (/dev/ttyAMA0).
Deze message lezen we aller eerst uit.
```python
# Read one message from the serial port and give back the nmea message.
# Example nmea message: !AIVDM,1,1,,B,13`fal0P010CQ;LMksnf4?v42<52,0*05
data = ai.read_serial()
```
Hierna decoden wij deze message.
```python
# Decode the nmea message into readable text, put this text into a dictionary.
decodedData = decode_ais(data)
```
De teruggegeven dictionary dumpen we dan naar een json string.
```python
# Form a json string from the dictionary for ease of use
dataString = json.dumps(decodedData)
```
De json string sturen wij d.m.v. een post request naar de webserver, hiervoor is wel een api key nodig zonder authentication.
```python
# Send the json string to the webserver, you need an api key for this to work without authentication.
req = rq.post(webserverURL, data = {'api_key': webserverAPIKey, 'data': dataString})
```
=======
Ook is het mogelijk om alle mmsi nummers van boten in de buurt uit te printen. Om dit aan te zetten hebben we een argument parser gebruikt. Deze parser zorgt ervoor dat je een argument in de python call kunt doen.
```shell
python <dir>/AIS_Receiver.py --mmsi <bool>
```

Hiervoor hebben we ook nog een functie geschreven.  
De functie maakt een list aan waar alle mmsi nummers in worden opgeslagen. Aangezien een list niet ordered is slaan we het aller eerste mmsi nummer ook nog op in een losse variable.
```python
def getAllMMSI(ser):
    mmsiList = list()
    firstData = ser.read_serial()
    firstDataDecoded = decode_ais(firstData)
    mmsiList.append(firstDataDecoded["mmsi"])
```
Na het opslaan van het eerste mmsi nummer wordt er een loop gestart waarin hij data uitleest van de AIS Hat, deze data decode hij.  Hierna checkt hij of het gekregen mmsi nummer niet hetzelfde is als het eerste nummer. Zo niet dan slaat hij hem op in de list.
```python
    while(True):
        data = ser.read_serial()
        decodedData = decode_ais(data)
        try:
            if decodedData["mmsi"] == firstDataDecoded["mmsi"]:
                break
            mmsiList.append(decodedData["mmsi"])
        except Exception:
            pass
```
Tot slot returned de functie de complete list.
```python
    return mmsiList
```

Deze functie word aangereoepen voordat de code data wil ontvangen en versturen naar de REST API. Het aanroepen van de functie word zo gedaan dat het er mooi uit ziet op de commandline. 
```python
if giveMMSI:
    print("Getting mmsi numbers... Please wait.")
    print("------------------------------------")
    for mmsi in getAllMMSI(ser):
        print(mmsi)
    print("------------------------------------")
```

## Hardware
[Link naar de documentatie over de hat](https://wegmatt.com/files/dAISy%20HAT%20AIS%20Receiver%20Quickstart.pdf) 
[Link naar de webshop van de hat](https://shop.wegmatt.com/products/daisy-hat-ais-receiver)

Voor de hardware van de AIS Receiver hebben we een raspberry pi 4 gebruikt. In theorie kun je alles vanaf een raspberry pi 2 gebruiken. (Zie de documentatie van de hat)  
Voor de raspberry pi heb je een powerbrick nodig die 5V/2.5A levert. De standaard raspberry pi charger is precies goed.  
Op de raspberry pi zit de bovenstaande hat gemonteerd. Aan deze hat zit weer een antenne vast.  
[Link naar een webshop die de antenne verkoopt](https://www.nauticgear.nl/banten/banten-rvs-vhf-marifoon-antenne-1-meter.html)  
Al deze hardware hebben wij in een custom laser cut doosje gestopt. 
[Link naar de .ai file](../ais-receiver/custom_box.ai)  
[&laquo; Back to the README.md](../README.md)


