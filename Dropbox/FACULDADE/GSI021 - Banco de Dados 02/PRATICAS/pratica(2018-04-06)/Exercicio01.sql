CREATE TABLE Paciente (
    CPF int,
    Nome varchar(100) NOT NULL,
    DataNascimento date,
    Endereco varchar(100) DEFAULT 'Uberlândia',
    CONSTRAINT cpf_pk PRIMARY KEY(CPF)
);

CREATE TABLE Medico(
    CRM varchar(50),
    UF varchar(50),
    Nome varchar(100),
    CPF int,
    Endereco varchar(50),
    Telefone int,
    CONSTRAINT crm_uf_pk PRIMARY KEY(CRM,UF) 
);

CREATE TABLE Consulta(
    CPF int,
    CodigoConvenio int,
    CRM varchar(50),
    UF varchar(50),
    Data date,
    Horario int,
    Valor int CHECK (Valor > 0),
    CONSTRAINT crm_uf_fk FOREIGN KEY(CRM,UF) REFERENCES Medico(CRM,UF),
    CONSTRAINT cpf_codConv_crm_uf_pk PRIMARY KEY(CPF,CodigoConvenio,CRM,UF)
);