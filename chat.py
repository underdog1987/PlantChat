#! /usr/bin/env python
import serial
import string
import sys
import urllib2
import json
import time
from random import randint

THIS_PLANT = 1 #Reemplazar a cada planta por un número unico
URL_MSG_VIEW = "http://yourserver.com/PlantChatWH/controller.php?c=getmessagesplant"
URL_MSG_SEND = "http://yourserver.com/PlantChatWH/controller.php?c=sendmessage"

# Tuplas y listas con mensajes
inbox = ("ola k ase", "Esperando que te rieguen o k ase", "Jaja.", "c-rafin.", "c-marnat.", "c-marmol" )
preguntas = ("Soy yo, o hace calor?", "Ni frio ni calor aqui, y ustedes?", "Que tal, ya las regaron?", "Como va su dia?", "Como andan?", )
mensajes = ("Vamo a chatea", "ola k ase", "Vamonos!!")
frases = ("temperatura", "frio", "buen clima", "calor", "calorts", "calorcito", "sequedad", "sed", "fresco", "lechuga", "exceso", "lodo", "k ase", "c-rafin", "c-marnat", "andan")


# Defs
def _getMessage():
	headers = {'User-Agent':'Raspberry Pi'}
	req1 = urllib2.Request(URL_MSG_VIEW, "", headers)
	response1=urllib2.urlopen(req1)
	return response1.read()

def _sendMessage(soobshcheniye, replyingto):
	#aki, ver si esta respondiendo a otra planta
	if replyingto >0:
		realMensajito="@"+str(replyingto) + " " + soobshcheniye
	else:
		realMensajito = soobshcheniye
	data = {'from':THIS_PLANT ,'mensaje': realMensajito}
	data2 = json.dumps(data)
	headers = {'Content-Type': 'application/json', 'Content-Length': len(data2), 'User-Agent':'Raspberry Pi'}
	req = urllib2.Request(URL_MSG_SEND, data2, headers)
	response=urllib2.urlopen(req)
	return response.read() # "OK" if success

def getMessageTemp(tempIndex):
	if tempIndex == -1:
		arr = ["No se que temperatura hace", "Algo raro pasa"]
	elif tempIndex == 0:
		arr = ["Uy, que frio", "Me congelo"]
	elif tempIndex == 1:
		arr = ["Ya se siente frio", "Mas frio que fresco"]
	elif tempIndex == 2:
		arr = ["Bastante fresco aqui", "Que buen clima", "Estoy fresca como lechuga xD"]
	elif tempIndex == 3:
		arr = ["Bastante fresco aqui", "Que buen clima"]
	elif tempIndex == 4:
		arr = ["Calorcito rico aqui", "Un poco de calor nada mas", "Ya me esta dando calor"]
	elif tempIndex == 5:
		arr = ["Hace mucho calorts aqui", "Me estoy asando", "Me derrito :("]
	e = randint(0,len(arr)-1)
	return arr[e]

def getMessageHum(humIndex):
	if humIndex == -1:
		arr = ["No se que humedad hace", "Algo raro pasa"]
	elif humIndex == 0:
		arr = ["Uy, que sequedad de tierra", "Me deshidrato, quiero agua"]
	elif humIndex == 1:
		arr = ["Ya me dio sed de la mala", "Ocupo que me rieguen"]
	elif humIndex == 2:
		arr = ["Bastante fresco aqui", "Mejor imposible", "Estoy fresca como lechuga xD"]
	elif humIndex == 3:
		arr = ["Empiezo a tener exceso de agua", "No mas agua por favorts"]
	elif humIndex == 4:
		arr = ["Estoy nadando, literal", "Tengo tanta agua que estoy en el lodo"]
	e = randint(0,len(arr)-1)
	return arr[e]
	

ser = serial.Serial("/dev/ttyACM1",9600)
lastMessage=""
# Valores obtenidos de los sensores
realTemp = 999 # Temperatura
realHum = 999 # Humedad
realLuz = 999 # Iluminacion

while True:
	try:
		# Obtener info del entorno
		if ser.inWaiting():
			valores = ser.readline()
			# Los valores se entregan con la siguiente sintaxis:
			# T=22.46|H=99.90|I=255
			arValores=valores.split("|")
			temp = arValores[0]
			hum = arValores[1]
			luz = arValores[2]
			
			# Convertirt los strings de valores a float (luz a entero)
			realTemp = float(temp.split("=")[1].strip())
			realHum = float(hum.split("=")[1].strip())
			realLuz = int(luz.split("=")[1].strip())
			#print valores
		# Determinar las condiciones del entorno
		# dia o noche (hipotesis)
		if realLuz == 999:
			isDay = -1
		else:
			isDay = 1 if realLuz <= 512 else 0

		# humedad de la tierra
		if realHum == 999:
			iHum = -1
		elif realHum <= 15.99:
			iHum = 0
		elif realHum >= 16 and realHum < 35.99:
			iHum = 1
		elif realHum >= 36 and realHum < 50.99:
			iHum = 2
		elif realHum >= 51 and realHum < 98.99:
			iHum = 3
		elif realHum >= 99:
			iHum = 4

		# temperatura
		if realTemp == 999:
			iTemp = -1
		elif realTemp <= 7.99:
			iTemp = 0
		elif realTemp >= 8 and realTemp < 13.99:
			iTemp = 1
		elif realTemp >= 14 and realTemp < 16.99:
			iTemp = 2
		elif realTemp >= 17 and realTemp < 22.99:
			iTemp = 3
		elif realTemp >= 23 and realTemp < 32.99:
			iTemp = 4
		elif realTemp >= 33:
			iTemp = 5
		
		print "Dia: " + str(realLuz)
		print "Humedad: " + str(realHum)
		print "Temperatura: " + str(realTemp)

		# Revisar si el ultimo mensaje require respuesta
		# para que el ultimo mensaje requira respuesta debe cumplirse una de las siguientes:
		# * que la planta este "arrobada"
		response = _getMessage()
		response=response[1:]
		partes = response.split("|")
		partes[1]=partes[1].lower()
		# Ver si arrobaron a la planta
		if int(partes[2]) == THIS_PLANT:
			if partes[1].endswith("."):
				pass
			else:
				#aqui saca respuesta de inbox y responde
				e = randint(0,len(inbox)-1)
				toSend = inbox[e]
				print "Enviar -> " + toSend
				print _sendMessage(toSend, int(partes[0]))
				pass
		# No arrobada 
		else:
			breaq=False
			trigger = ""
			if int(partes[0]) != THIS_PLANT: # para que no se conteste a ella misma
				# (aqui se analiza el mensaje de entrada y responde)
				# generar respuestas en base a las palabras del mensaje
				for frase in frases:
					#print frase + " --> " + partes[1]
					if frase in partes[1]:
						trigger = frase.lower()
						print "[ ! ] " + trigger
						breaq=True
				if not breaq:
					# Generar mensaje al azar o lanza pregunta
					# 0 = pregunta
					# 1 = mensaje desma
					# 2 = mensaje temperatura
					# 3 = mensaje humedad
					# TODO 4 = mensaje entorno (temp + hum) 
					q = randint(0,3)
					if q == 0:
						e = randint(0,len(preguntas)-1)
						toSend = preguntas[e]
					elif q == 1:
						e = randint(0,len(mensajes)-1)
						toSend = mensajes[e]
					elif q == 2:
						toSend = getMessageTemp(iTemp)
					elif q == 3:
						toSend = getMessageHum(iHum)
					else:
						toSend = "Paso algo raro..."
				else:
					print trigger
					rpt = partes[0] if partes[1].endswith("?") else 0
					if trigger in ["c-rafin", "c-marnat", "lechuga"]:
						toSend = "Jaja."
					elif trigger in ["k ase"]:
						toSend = "C-rafin"
					elif trigger in ["exceso", "sequedad","sed", "fresco", "buen clima", "lodo"]:
						toSend = getMessageHum(iHum)
					elif trigger in ["andan", "temperatura","frio", "calor", "calorcito", "lodo"]:
						toSend = getMessageTemp(iTemp)
					else:
						toSend = "OK."
				print "Enviar -> " + toSend
				print _sendMessage(toSend, rtp)

		time.sleep(10)
	except KeyboardInterrupt:
		print "[ ! ] Cerrando...." # Debug only
		ser.close()
		sys.exit(1)
	except Exception as e:
		print str(e)
		pass
