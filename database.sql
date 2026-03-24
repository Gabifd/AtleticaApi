CREATE TABLE Perfil (
    idPerfil INT AUTO_INCREMENT PRIMARY KEY,
    nmPerfil VARCHAR(250) NOT NULL,
    dePerfil VARCHAR(250) NULL
);

CREATE TABLE Usuario (
    idUsuario INT AUTO_INCREMENT PRIMARY KEY,
    nmUsuario VARCHAR(100) NOT NULL,
    deEmail VARCHAR(100) NOT NULL UNIQUE,
    deSenha VARCHAR(255) NOT NULL,
    cdSexo TINYINT NOT NULL,
    idPerfil INT NOT NULL,
    dtNascimento DATE NOT NULL,
    opTermo TINYINT(1) NOT NULL DEFAULT 0,
    dtCadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_usuario_perfil
        FOREIGN KEY (idPerfil)
        REFERENCES Perfil(idPerfil)
);
