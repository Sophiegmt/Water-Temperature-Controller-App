drop table if exists temp;
drop table if exists users;


SET @@auto_increment_increment=1;


create table users
    (username varchar(255) not null,
    password varchar(255) not null,
    minTemp numeric(5,2) not null,
    maxTemp numeric(5,2) not null,
    WBdefault integer not null,
    primary key(username));

create table temp
    (temperature numeric(5,2) not null,
   	username varchar(255) not null,
    time_st int not null,
    primary key(username, time_st),
    foreign key(username) references users(username) on delete cascade on update cascade);
