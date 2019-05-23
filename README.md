# PlantChat
Una prueba de concepto donde se hace que una planta "platique" con otras.

Para construir los mensajes, la planta obtiene datos su  utilizando sensores y un Arduino UNO.
Los datos que obtiene son:
  - Temperatura
  - Humedad
  - Iluminacion

Las lecturas se realizan cada 10 segundos.

Un script en Python se encarga de estructurar los mensajes usando los datos entregados por el Arduino y los envía a la aplicación Web, que se encarga de mostrar el Chat.
