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



-- EVENTS
CREATE EVENT `Call_timeout` ON SCHEDULE EVERY 1 SECOND ON COMPLETION NOT PRESERVE ENABLE DO CALL timeout();

