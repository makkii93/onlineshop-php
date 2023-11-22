create table produkt (
    id int(11) not null auto_increment primary key,
    name varchar(255) not null,
    bechreibung varchar(255),
    kategorie varchar(255),
    menge int(11) not null,
    preis float(22,3) not null
);

create table bestellposition (
    id int(11) not null auto_increment primary key,
    produkt_id int(11) not null,
    menge int(11) not null,
    preis float(13,4) not null,
    foreign key (produkt_id) references produkt (id)
);

CREATE TABLE bestellung (
    id int(11) not null auto_increment primary key,
    datum datetime not null,
    zahlungsart varchar(255) not null
);