# Documentacion del proyecto  _(SECURITY-ENVIRONMENT--SE-)_

### ENCARGADO DE ESTA TABLA: JOSE MARIANO 
_NIVEL DE DIFICULTAD: INTERMEDIO_
_TIEMPO DE ENTREGA: 2-3 DIAS_

## Apartado de registro y proceso de casos

TABLA CASOS (ULTIMA TABLA EN SER CREADA)

- id caso PRIMARY KEY
- tipo de caso - relacion con tabla casoType - llave foranea
- descripcion
- fecha y hora de registro 
- fecha y hora del hecho 
- lugar (provincias) - llave foranea
- status - relacion con la tabla statusCaso  llave foranea
- agente - quien atiende el caso - llave foranea

CREATE TABLE caso(
    idCaso INT(50) PRIMARY KEY AUTO_INCREMENT,
    FOREING KEY (casos_tipoCaso) REFERENCES  casos_tipoCaso(idcaso),
    Descriocion VARCHAR(1500),
    Registro_fecha TIMESTAMP
    Hecho_fecha TIMESTAMP,
    FOREING KEY (provincias)  REFERENCES provincias(id_provincias),
    FOREING KEY (status_caso) REFERENCES status_caso(id_status),
    FOREING KEY (admin) REFERENCES admin(idAdmin)
);

YA ESTA CREADA

TABLA admin (agentes)



### ENCARGADO DE ESTA TABLA: KENNY ARTURO
_NIVEL DE DIFICULTAD: FACIL_
_TIEMPO DE ENTREGA: 1 DIA_

- TABLA provincias
- Id provincia
- provincia 

CREATE TABLE provincias (
    id_provincia INT(50)PRIMARY KEY AUTO_INCREMENT,
    provincia VARCHAR (50)
    )
    
INSERT INTO provincias (provincia) VALUES
('Azua'),
('Bahoruco'),
('Barahona'),
('Dajabón'),
('Distrito Nacional'),
('Duarte'),
('El Seybo'),
('Elías Piña'),
('Espaillat'),
('Hato Mayor'),
('Independencia'),
('La Altagracia'),
('La Romana'),
('La Vega'),
('Monseñor Nouel'),
('Monte Cristi'),
('Monte Plata'),
('Pedernales'),
('Peravia'),
('Puerto Plata'),
('Samaná'),
('San Cristóbal'),
('San José de Ocoa'),
('San Juan'),
('San Pedro de Macorís'),
('Sánchez Ramírez'),
('Santiago'),
('Santiago Rodríguez'),
('Valverde'),
('La Vega'),
('San Francisco de Macorís'),
('Santo Domingo');

---



### ENCARGADO DE ESTA TABLA: LEAN MANUEL
_NIVEL DE DIFICULTAD: FACIL_
_TIEMPO DE ENTREGA: 1 DIA_

CREATE TABLE status_caso (
    id_status int(50) primary key AUTO_INCREMENT,
    status varchar(255)
    )
    INSERT INTO status_caso (status) VALUES ("Pendiente"),("En curso"),("Declinado"),("Suspendida"),("Cerrado"),("Reabierto"),("Resuelto") 


---



### ENCARGADO DE ESTA TABLA: JOSE LEONARDO Y GREGORY MARTINEZ
_NIVEL DE DIFICULTAD: FACIL_
_TIEMPO DE ENTREGA: 1 DIA_

TABLA casoType

- idType
- tipo
- incluyentes (que engloba este tipo de caso)

---



### ENCARGADO DE ESTA TABLA: KELVIN RAMIREZ 

_NIVEL DE DIFICULTAD: FACIL_
_TIEMPO DE ENTREGA: 1_

TABLA RELACION casos-tipoCaso (relacion entre caso y tipo de caso)

- idcaso
- idtype

---




## DINAMICA:

**CADA UNO VA A CREAR SUS SCRIPTS PARA LAS TABLAS Y LUEGO SE JUNTARAN TODAS EN UN
SOLO SCRIPT PARA COMPROBAR SU CORRECTO FUNCIONAMIENTO Y LUEGO SER AÑADIDA A LA 
DB OFICIAL Y LUEGO A LA RAMA CORRESPONDIENTE**

_CADA UNO TRABAJARA EN LA RAMA: "REGISTRO DE CASOS"_

---
