[&laquo; Back to the README.md](../README.md)

# AIS Reciver Documentatie
Om de boten te kunnen tracken op de website heb je een raspberry pi met een AIS receiver nodig. Op deze pagina zullen we uitleggen hoe dat in zijn werking gaat.

## Python client code
[Link naar de client code](../ais-receiver/ais-receiver.py)
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
Om een message te kunnen ontvangen op de raspberry pi gebruiken we een head (hierover meer in het kopje hardware).
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

## Hardware
Charlie TODO nederlands gewoon...
