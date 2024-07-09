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





CREATE DATABASE security_environment;

CREATE TABLE users(
   idUser INT(10) PRIMARY KEY AUTO_INCREMENT NOT NULL,
   username varchar(60) NOT NULL,
   emailName varchar(60) NOT NULL,
   email varchar(100) NOT NULL,
   password varchar(255) NOT NULL,
   created_at TIMESTAMP NOT NULL
);

CREATE TABLE token(
   idToken INT(10) PRIMARY KEY AUTO_INCREMENT NOT NULL,
   token INT(255) NOT NULL,
   created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
   kill_at TIMESTAMP NULL DEFAULT NULL,
   intentos INT(10),
   contador INT(10),
   Is_revoked BOOLEAN DEFAULT FALSE 
);

CREATE TABLE userTokens(
    user_id INT(10) NOT NULL,
    token_id INT(10) NOT NULL,
    PRIMARY KEY (user_id, token_id),
    FOREIGN KEY (user_id) REFERENCES users(idUser) ON DELETE CASCADE,
    FOREIGN KEY (token_id) REFERENCES token(idToken) ON DELETE CASCADE,
    assigned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- DOCUMENTACION DE ERRORES 😒
-- HOY ME LLEVO EL DEVIL, ASEGURARSE DE DECLARAR LA LLAVE PRIMARIA ANTES DE CREAR
-- UNA TABLA DE RELACION CON LLAVES PRIMARIAS REFERENCIADAS 