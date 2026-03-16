create table users(
    id integer primary key,
    username varchar(100) not null,
    password varchar(150) not null
);

create table posts(
    id integer primary key,
    title varchar(150) not null,
    content text not null ,
    slug text not null,
    published_at datetime default current_timestamp,
    updated_at datetime default current_timestamp
);

CREATE TRIGGER update_posts_updated_at
    AFTER UPDATE ON posts
    FOR EACH ROW
BEGIN
    UPDATE posts
    SET updated_at = CURRENT_TIMESTAMP
    WHERE id = OLD.id;
END;
