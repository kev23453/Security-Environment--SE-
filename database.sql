/*
user
   -idUser INT
   -username varchar
   -emailName varchar
   -email varchar
   -password varchar
   -created_at DATE O TIMESTAMP

token
   -idToken INT
   -token INT
   -created_at DATE O TIMESTAMP
   -kill_at DATE O TIMESTAMP
   -intentos INT
   -contador INT
   -Is_revoked: BOLEANO 

userTokens
    -idUser INT
    -idToken INT
    -assigned_at DATE O TIMESTAMP
*/

-- PRODUCTOS

-- ID: INT
-- NOMBRE VARCHAR 
-- CODIGO INT
-- PRECIO DOUBLE
-- CATEGORIA VARCHAR
-- STOCK: 48

CREATE DATABASE security_environment;

USE security_environment;

CREATE TABLE users(
   idUser INT(10) PRIMARY KEY AUTO_INCREMENT NOT NULL,
   username varchar(60) NOT NULL,
   emailName varchar(60) NOT NULL,
   email varchar(100) NOT NULL,
   password varchar(255) NOT NULL,
   created_at TIMESTAMP NOT NULL,
   verify BOOLEAN DEFAULT FALSE 
);

CREATE TABLE tokenType(
   idType INT(10) PRIMARY KEY AUTO_INCREMENT NOT NULL,
   type varchar(50) NOT NULL
);

CREATE TABLE token(
   idToken INT(10) PRIMARY KEY AUTO_INCREMENT NOT NULL,
   token VARCHAR(255) NOT NULL,
   created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
   kill_at TIMESTAMP NULL DEFAULT NULL,
   intentos INT(10) NOT NULL DEFAULT 3,
   contador INT(10),
   Is_revoked BOOLEAN DEFAULT FALSE,
   idType INT(50) NOT NULL,
   FOREIGN KEY (idType) REFERENCES tokenType(idType)
);

CREATE TABLE userTokens(
    user_id INT(10) NOT NULL,
    token_id INT(10) NOT NULL,
    PRIMARY KEY (user_id, token_id),
    FOREIGN KEY (user_id) REFERENCES users(idUser) ON DELETE CASCADE,
    FOREIGN KEY (token_id) REFERENCES token(idToken) ON DELETE CASCADE,
    assigned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE adminType(
   idType INT(10) PRIMARY KEY AUTO_INCREMENT NOT NULL,
   type CHAR(15) NOT NULL
);

CREATE TABLE admin(
   idAdmin INT(10) PRIMARY KEY AUTO_INCREMENT NOT NULL, -- definira el id del administrador
   username VARCHAR(60) NOT NULL, -- el username de ese administrador
   emailName VARCHAR(60) NOT NULL, -- el nombre de usuario de su correo electronico
   email VARCHAR(100) NOT NULL, -- email del administrador para el envio de correos electronicos
   password VARCHAR(255) NOT NULL, -- la contraseña del administrador, normalmente el administrador sera creado por el admin prime
   adminType INT NOT NULL,
   FOREIGN KEY(adminType) REFERENCES adminType(idType)
   -- reader: solo puede leer el contenido del dashboard, 
             -- uno que pueda editar
             -- un usuario que estara con las credenciales en .env (propietario)
);

CREATE TABLE admin_adminType(
   idAdmin INT,
   idType INT,
   PRIMARY KEY (idAdmin, idType),
   FOREIGN KEY (idAdmin) REFERENCES admin(idAdmin),
   FOREIGN KEY (idType) REFERENCES adminType(idType)
);

<<<<<<< HEAD






CREATE TABLE provincia (
    id_provincia INT(50) PRIMARY KEY AUTO_INCREMENT, 
    provincia VARCHAR (50)
);

INSERT INTO provincia(provincia) VALUES ('Azua'), ('Bahoruco'), ('Barahona'), ('Dajabón'), ('Distrito Nacional'), ('Duarte'), ('El Seybo'), ('Elías Piña'), ('Espaillat'), ('Hato Mayor'), ('Independencia'), ('La Altagracia'), ('La Romana'), ('La Vega'), ('Monseñor Nouel'), ('Monte Cristi'), ('Monte Plata'), ('Pedernales'), ('Peravia'), ('Puerto Plata'), ('Samaná'), ('San Cristóbal'), ('San José de Ocoa'), ('San Juan'), ('San Pedro de Macorís'), ('Sánchez Ramírez'), ('Santiago'), ('Santiago Rodríguez'), ('Valverde'), ('La Vega'), ('San Francisco de Macorís'), ('Santo Domingo');




CREATE TABLE status_caso(
    id_status int(50) primary key AUTO_INCREMENT,
    status varchar(255)
);

INSERT INTO status_caso(status) VALUES("Pendiente"),("En curso"),("Declinado"),("Suspendida"),("Cerrado"),("Reabierto"),("Resuelto");






CREATE TABLE casoType ( 
    id_casotype int(255) PRIMARY KEY AUTO_INCREMENT,
    type VARCHAR (500)
);

INSERT INTO casoType(type) VALUES ('violencia_de_genero'),('agrecion'),('robo'),('estafas'),('homicidio');




CREATE TABLE caso( 
    idCaso INT(50) PRIMARY KEY AUTO_INCREMENT,
    tipoCaso INT, -- llave foranea
    description VARCHAR(1500), 
    registro_fecha TIMESTAMP,
    hecho_fecha DATE,
    place INT, -- llave foranea
    status INT, -- llave foranea
    agente INT, -- llave foranea
    FOREIGN KEY (place) REFERENCES provincia(id_provincia),
    FOREIGN KEY (status) REFERENCES status_caso(id_status),
    FOREIGN KEY (agente) REFERENCES admin(idAdmin),
    FOREIGN KEY (tipoCaso) REFERENCES casoType(id_casotype)
);


create table casos_tipocaso ( 
    idCaso int(255),
    idType int(255),
    primary key (idCaso, idType),
    foreign key (idCaso) references caso(idCaso),
    foreign key (idType) references casotype(id_casotype)
);

-- ALTER TABLE caso ADD FOREIGN KEY (tipoCaso) REFERENCES casos_tipoCaso(idcaso)










=======
>>>>>>> 53fdc6f62585d9573b45965db9cb317d4e85d0d0
-- PROCEDURES
DELIMITER //

CREATE PROCEDURE timeout()
BEGIN
    DECLARE fecha_actual TIMESTAMP;
    SET fecha_actual = NOW();

    UPDATE token 
    SET token.Is_revoked = 1
    WHERE fecha_actual >= token.kill_at;

    UPDATE token 
    SET token.Is_revoked = 1
    WHERE token.contador = 3;
END //

DELIMITER ;

<<<<<<< HEAD







-- EVENTS
CREATE EVENT `Call_timeout` ON SCHEDULE EVERY 1 SECOND ON COMPLETION NOT PRESERVE ENABLE DO CALL timeout();













=======
-- EVENTS
CREATE EVENT `Call_timeout` ON SCHEDULE EVERY 1 SECOND ON COMPLETION NOT PRESERVE ENABLE DO CALL timeout();
>>>>>>> 53fdc6f62585d9573b45965db9cb317d4e85d0d0
