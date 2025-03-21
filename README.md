# NASA API

El proyecto consume la API de DONKI de la NASA y proporciona endpoints para obtener información sobre instrumentos y actividades.

## Requisitos

- PHP ^8.2
- Laravel ^12.0

## Dependencias

Revisar archivo composer.json

## Instalación

1. Clonar repositorio:
   git clone https://github.com/e-rios/nasa-api.git
   cd api-nasa

2. Instalar dependencias:
    composer install

3. Configurar archivo .env
    Generar tu API Key en https://api.nasa.gov/ y agregarla en el archivo
    NASA_API_KEY=api_key_generada

4. Generar clave de la aplicación
    php artisan key:generate

5. Ejecutar servidor
    php artisan serve
    http://127.0.0.1:8000

## Estructura del proyecto

app/
├── Http/
│    └── Controllers/
├── Models/
├── Providers/
└── Services/
config/
database/
public/
resources/
routes/
tests/

## Endpoints

1. Obtener todos los instrumentos
    Método: GET
    Ruta: /donki/instruments
    Respuesta:
    {"instruments":["SOHO: LASCO\/C2","SOHO: LASCO\/C3","STEREO A: SECCHI\/COR2","STEREO A: IMPACT","STEREO A: PLASTIC","ACE: MAG","ACE: SWEPAM","DSCOVR: PLASMAG","GOES-P: EXIS 1.0-8.0","SOHO: COSTEP 15.8-39.8 MeV","MODEL: REleASE:SOHO\/EPHIN 15.8-39.8 MeV","GOES-P: SEISS >10 MeV","MODEL: REleASE:SOHO\/EPHIN 28.2-50.1 MeV","STEREO A: IMPACT 13-100 MeV","SOHO: COSTEP 28.2-50.1 MeV","GOES-P: SEISS >2MeV"]}

2. Obtener todos los IDs de actividades
    Método: GET
    Ruta: /donki/activity-ids
    Respuesta:
    {"activityIDs":["2025-02-19T23:23:00-FLR-001","2025-02-23T14:08:00-IPS-001","2025-02-23T21:20:00-IPS-001","2025-02-22T20:55:00-FLR-001","2025-02-23T02:00:00-FLR-001","2025-02-23T19:22:00-FLR-001","2025-02-24T06:53:00-FLR-001","2025-02-26T05:26:00-IPS-001","2025-02-27T09:00:00-GST-001","2025-02-24T21:50:00-FLR-001","2025-02-25T00:11:00-SEP-001","2025-02-25T00:17:00-SEP-001","2025-02-25T00:20:00-SEP-001","2025-02-25T00:42:00-SEP-001","2025-02-25T03:05:00-SEP-001","2025-02-25T03:52:00-SEP-001","2025-02-25T11:20:00-FLR-001","2025-02-28T08:30:00-IPS-001","2025-02-28T19:32:00-IPS-001","2025-02-26T22:37:00-FLR-001","2025-03-01T03:22:00-SEP-001","2025-02-28T16:18:00-FLR-001","2025-03-04T17:10:00-IPS-001","2025-03-07T17:35:00-RBE-001","2025-03-01T22:44:00-FLR-001","2025-03-02T03:37:00-FLR-001","2025-03-02T05:46:00-FLR-001","2025-03-02T09:26:00-FLR-001","2025-03-07T20:54:00-FLR-001","2025-03-10T13:44:00-IPS-001","2025-03-11T13:03:00-FLR-001","2025-03-11T21:19:00-FLR-001","2025-03-21T10:10:00-IPS-001","2025-03-17T19:04:00-FLR-001","2025-03-17T19:25:00-FLR-001","2025-03-19T23:04:00-FLR-001","2025-03-20T16:49:00-FLR-001","2025-02-24T07:00:00-CME-001","2025-02-26T12:36:00-HSS-001","2025-03-08T04:48:00-IPS-001","2025-03-08T15:00:00-HSS-001","2025-03-12T14:17:00-HSS-001","2025-02-20T00:00:00-CME-001","2025-02-22T21:36:00-CME-001","2025-02-23T02:36:00-CME-001","2025-02-23T19:36:00-CME-001","2025-02-24T21:24:00-CME-001","2025-02-25T12:38:00-CME-001","2025-02-27T00:12:00-CME-001","2025-02-28T17:24:00-CME-001","2025-03-01T23:36:00-CME-001","2025-03-02T04:00:00-CME-001","2025-03-02T06:24:00-CME-001","2025-03-02T09:48:00-CME-001","2025-03-07T21:49:00-CME-001","2025-03-11T14:00:00-CME-001","2025-03-11T22:24:00-CME-001","2025-03-17T19:48:00-CME-001","2025-03-17T20:12:00-CME-001","2025-03-19T23:24:00-CME-001","2025-03-20T17:12:00-CME-001","2025-02-28T17:12:00-CME-001","2025-03-01T18:24:00-CME-001","2025-03-02T15:10:00-RBE-001","2025-03-09T03:00:00-GST-001","2025-03-10T11:50:00-RBE-001","2025-03-10T06:30:00-IPS-001","2025-03-13T13:10:00-RBE-001","2025-03-14T00:00:00-GST-001","2025-03-18T15:10:00-IPS-001"]}

3. Obtener porcentaje de uso de todos los instrumentos
    Método: GET
    Ruta: /donki/instrument-usage
    Respuesta:
    {"instruments_use":{"SOHO: LASCO\/C2":0.0625,"SOHO: LASCO\/C3":0.0625,"STEREO A: SECCHI\/COR2":0.0625,"STEREO A: IMPACT":0.0625,"STEREO A: PLASTIC":0.0625,"ACE: MAG":0.0625,"ACE: SWEPAM":0.0625,"DSCOVR: PLASMAG":0.0625,"GOES-P: EXIS 1.0-8.0":0.0625,"SOHO: COSTEP 15.8-39.8 MeV":0.0625,"MODEL: REleASE:SOHO\/EPHIN 15.8-39.8 MeV":0.0625,"GOES-P: SEISS >10 MeV":0.0625,"MODEL: REleASE:SOHO\/EPHIN 28.2-50.1 MeV":0.0625,"STEREO A: IMPACT 13-100 MeV":0.0625,"SOHO: COSTEP 28.2-50.1 MeV":0.0625,"GOES-P: SEISS >2MeV":0.0625}}

4. Obtener porcentaje de uso de un instrumento
    Método: POST
    Ruta: /donki/instrument-activity-usage
    Cuerpo: 
    {
        "instrument": "STEREO A: IMPACT"
    }
    Respuesta:
    {"instrument_activity":{"STEREO A: IMPACT":{"2025-02-28T19:32:00-IPS-001":0.5,"2025-03-10T06:30:00-IPS-001":0.5}}}
