DROP TABLE IF EXISTS Users;
DROP TABLE IF EXISTS Product;
DROP TABLE IF EXISTS Shipment;
DROP TABLE IF EXISTS Category;
DROP TABLE IF EXISTS Size;
DROP TABLE IF EXISTS Condition;
DROP TABLE IF EXISTS ShoppingCart;
DROP TABLE IF EXISTS WishList;
DROP TABLE IF EXISTS Chat;
DROP TABLE IF EXISTS Comment;



CREATE TABLE Users (
  id INTEGER PRIMARY KEY,
  username VARCHAR UNIQUE,      -- unique username
  password VARCHAR,                  -- password stored in sha-1
  name VARCHAR,                      -- real name
  email VARCHAR,
  isAdmin INTEGER DEFAULT FALSE,
  isBanned INTEGER DEFAULT FALSE                 
);

CREATE TABLE Product (
  id INTEGER PRIMARY KEY,
  title VARCHAR,
  description VARCHAR,
  price DECIMAL(3,10),
  image VARCHAR,
  isBought BOOLEAN DEFAULT FALSE,
  creationDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  model VARCHAR,
  brand VARCHAR,
  creator_id INTEGER,
  category_id INTEGER,
  size_id INTEGER,
  condition_id INTEGER,
  FOREIGN KEY(creator_id) REFERENCES Users(id),
  FOREIGN KEY(category_id) REFERENCES Category(id),
  FOREIGN KEY(size_id) REFERENCES Size(id),
  FOREIGN KEY(condition_id) REFERENCES Condition(id)
);

CREATE TABLE Shipment(
  id INTEGER PRIMARY KEY,
  address VARCHAR NOT NULL,
  type VARCHAR CHECK(type = "Delivery" or type="Collect"),
  methodPayment VARCHAR CHECK(methodPayment = "OnDelivery" or methodPayment="BeforeShipment"),
  dateOfShipment TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  product_id INTEGER,
  buyer_id INTEGER,
  FOREIGN KEY(product_id) REFERENCES Product(id),
  FOREIGN KEY(buyer_id) REFERENCES Users(id)
);

CREATE TABLE Category(
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  name VARCHAR NOT NULL
);

CREATE TABLE Size(
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  name VARCHAR NOT NULL
);

CREATE TABLE Condition(
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  name VARCHAR NOT NULL
);

CREATE TABLE ShoppingCart(
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  user_id INTEGER,
  product_id INTEGER,
  FOREIGN KEY(user_id) REFERENCES Users(id),
  FOREIGN KEY(product_id) REFERENCES Product(id)
);

CREATE TABLE WishList(
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  user_id INTEGER,
  product_id INTEGER,
  FOREIGN KEY(user_id) REFERENCES Users(id),
  FOREIGN KEY(product_id) REFERENCES Product(id)
);

Create Table Chat(
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  user_id INTEGER,
  seller_id INTEGER,
  product_id INTEGER,
  FOREIGN KEY(user_id) REFERENCES Users(id),
  FOREIGN KEY(seller_id) REFERENCES Users(id),
  FOREIGN KEY(product_id) REFERENCES Product(id)
);

Create Table Comment(
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  content VARCHAR NOT NULL,
  dateMessage TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  chat_id INTEGER,
  user_id INTEGER,
  FOREIGN KEY(user_id) REFERENCES Users(id),
  FOREIGN KEY(chat_id) REFERENCES Chat(id)
);

INSERT INTO Users(username, password, name, email) values ("testUser","7110eda4d09e062aa5e4a390b0a572ac0d2c0220","User Tester","test@example.com");

-- Insert Categories
INSERT INTO Category(name) VALUES ('Electronics');
INSERT INTO Category(name) VALUES ('Clothing');
INSERT INTO Category(name) VALUES ('Books');

-- Insert Sizes
INSERT INTO Size(name) VALUES ('Small');
INSERT INTO Size(name) VALUES ('Medium');
INSERT INTO Size(name) VALUES ('Large');

-- Insert Conditions
INSERT INTO Condition(name) VALUES ('New');
INSERT INTO Condition(name) VALUES ('Used');
INSERT INTO Condition(name) VALUES ('Refurbished');

-- Insert Products
INSERT INTO Product(title, description, price, image, creator_id, category_id, size_id, condition_id,brand,model) VALUES ('Smartphone', 'Brand new smartphone with high-resolution display.', 799.99, '/images/smartphone.jpg', 1, 1, 1, 1,'SangueSuga','A30');
INSERT INTO Product(title, description, price, image, creator_id, category_id, size_id, condition_id,brand,model) VALUES ('T-shirt', '100% cotton t-shirt with classic design.', 19.99, '/images/tshirt.jpg', 1, 2, 2, 1,'Levi','T-Shirt');
INSERT INTO Product(title, description, price, image, creator_id, category_id, size_id, condition_id,brand,model) VALUES ('Book', 'Bestselling novel by a renowned author.', 29.99, '/images/book.jpg', 1, 3, 1, 1,'Porto Editora','Arnaldo');
INSERT INTO Product(title, description, price, image, creator_id, category_id, size_id, condition_id, brand,model) 
VALUES 
('Laptop', 'Powerful laptop with SSD storage.', 1299.99, '/images/book.jpg', 1, 1, 1, 1, 'TechMaster',"HP"),
('Jeans', 'Classic denim jeans for everyday wear.', 39.99, '/images/smartphone.jpg', 1, 2, 2, 1, 'Wrangler',"Ganga"),
('Cookbook', 'Collection of delicious recipes for home cooking.', 24.99, '/images/tshirt.jpg', 1, 3, 1, 1, 'Kitchen Delights',"Tia Teresa");
-- Insert Shipments
INSERT INTO Shipment(address, type, methodPayment, product_id, buyer_id) VALUES ('123 Main St, Cityville', 'Delivery', 'OnDelivery', 1, 1);
INSERT INTO Shipment(address, type, methodPayment, product_id, buyer_id) VALUES ('456 Elm St, Townsville', 'Collect', 'BeforeShipment', 2, 1);

-- Insert Shopping Cart
INSERT INTO ShoppingCart(user_id, product_id) VALUES (1, 1);
INSERT INTO ShoppingCart(user_id, product_id) VALUES (1, 2);

-- Insert Wishlist
INSERT INTO WishList(user_id, product_id) VALUES (1, 3);

INSERT INTO Users(username, password, name, email) VALUES 
("user2", "7110eda4d09e062aa5e4a390b0a572ac0d2c0220", "User Two", "user2@example.com"),
("user3", "7110eda4d09e062aa5e4a390b0a572ac0d2c0220", "User Three", "user3@example.com"),
("user4", "7110eda4d09e062aa5e4a390b0a572ac0d2c0220", "User Four", "user4@example.com"),
("user5", "7110eda4d09e062aa5e4a390b0a572ac0d2c0220", "User Five", "user5@example.com"),
("user6", "7110eda4d09e062aa5e4a390b0a572ac0d2c0220", "User Six", "user6@example.com"),
("user7", "7110eda4d09e062aa5e4a390b0a572ac0d2c0220", "User Seven", "user7@example.com"),
("user8", "7110eda4d09e062aa5e4a390b0a572ac0d2c0220", "User Eight", "user8@example.com"),
("user9", "7110eda4d09e062aa5e4a390b0a572ac0d2c0220", "User Nine", "user9@example.com"),
("user10", "7110eda4d09e062aa5e4a390b0a572ac0d2c0220", "User Ten", "user10@example.com"),
("user11", "7110eda4d09e062aa5e4a390b0a572ac0d2c0220", "User Eleven", "user11@example.com");

INSERT INTO Users(username, password, name, email, isAdmin) VALUES
("user777", "7110eda4d09e062aa5e4a390b0a572ac0d2c0220", "THE USER", "4dm1n_0@example.com", TRUE);
INSERT INTO Users(username, password, name, email, isAdmin, isBanned) VALUES
("user666", "7110eda4d09e062aa5e4a390b0a572ac0d2c0220", "THE USER", "b4dm4n_0@example.com", FALSE, TRUE);

-- Insert Chats
INSERT INTO Chat(user_id, seller_id, product_id) VALUES (1, 2, 1);
INSERT INTO Chat(user_id, seller_id, product_id) VALUES (1, 3, 2);

-- Insert Comments
INSERT INTO Comment(content, chat_id, user_id) VALUES ('Interested in this item.', 1, 2);
INSERT INTO Comment(content, chat_id, user_id) VALUES ('When can I collect?', 2, 2);
INSERT INTO Comment(content, chat_id, user_id) VALUES ('What doubts can I clarify about it?', 1, 1);