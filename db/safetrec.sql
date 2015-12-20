CREATE SCHEMA safetrec;

CREATE TABLE safetrec.agency (
  id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(45) NOT NULL,
  description VARCHAR(1000) NULL,
  PRIMARY KEY (id));
  
  drop table safetrec.division;

  CREATE TABLE safetrec.division (
  id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(45) NOT NULL,
  description VARCHAR(1000) NULL,
  agency_id INT NOT NULL,
  PRIMARY KEY (id),
  INDEX FK_agency_id_idx (agency_id ASC),
  CONSTRAINT FK_agency_id
    FOREIGN KEY (agency_id)
    REFERENCES safetrec.agency (id)
    ON DELETE CASCADE
    ON UPDATE CASCADE);


 CREATE TABLE safetrec.user (
  id INT NOT NULL AUTO_INCREMENT,
  first_name VARCHAR(45) NOT NULL,
  last_name VARCHAR(45) NOT NULL,
  phone VARCHAR(15) NULL,
  email VARCHAR(100) NOT NULL,
  password VARCHAR(100) NOT NULL,
  role VARCHAR(45) NOT NULL,
  fax VARCHAR(15) NULL,
  last_activity DATETIME NOT NULL,
  agency_id INT NOT NULL,
  division_id INT NULL,
  PRIMARY KEY (id),
  CONSTRAINT FK_agency_id_1
    FOREIGN KEY (agency_id)
    REFERENCES safetrec.agency (id)
    ON DELETE CASCADE
    ON UPDATE CASCADE);

 CREATE TABLE safetrec.challenge_area (
  id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(1000) NOT NULL,
  leader1_id INT NOT NULL,
  leader2_id INT NOT NULL,
  PRIMARY KEY (id),
   CONSTRAINT FK_leader1_id
    FOREIGN KEY (leader1_id)
    REFERENCES safetrec.user (id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
    CONSTRAINT FK_leader2_id
    FOREIGN KEY (leader2_id)
    REFERENCES safetrec.user (id)
    ON DELETE CASCADE
    ON UPDATE CASCADE);
;

 CREATE TABLE safetrec.strategy (
  id INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(1000) NOT NULL,
  description VARCHAR(2000) NULL,
  challenge_id INT NOT NULL,
  PRIMARY KEY (id),
  INDEX FK_challenge_id_idx (challenge_id ASC),
  CONSTRAINT FK_challenge_id
    FOREIGN KEY (challenge_id)
    REFERENCES safetrec.challenge_area (id)
    ON DELETE CASCADE
    ON UPDATE CASCADE);

 CREATE TABLE safetrec.action (
  id INT NOT NULL AUTO_INCREMENT,
  strategy_id INT NOT NULL,
  description VARCHAR(5000) NOT NULL,
  status varchar(100) NOT NULL,
  lead_id INT NOT NULL,
  agency_id INT NULL,
  division_id INT NULL,
  start_date DATETIME NOT NULL,
  end_date DATETIME NOT NULL,
  timing VARCHAR(100) NULL,
  data_info_prob_id VARCHAR(2000) NULL,
  proven_countermeasure VARCHAR(2000) NULL,
  plan_eval VARCHAR(5) NULL,
  resources VARCHAR(1000) NULL,
  scope_reach VARCHAR(100) NULL,
  legislative VARCHAR(100) NULL,
  last_activity datetime NOT NULL,
  PRIMARY KEY (id),
  INDEX FK_strategy_id_idx (strategy_id ASC),
  INDEX FK_division_id_1_idx (division_id ASC),
  INDEX FK_agency_id_2_idx (agency_id ASC),
  CONSTRAINT FK_strategy_id
    FOREIGN KEY (strategy_id)
    REFERENCES safetrec.strategy (id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT FK_lead_id
    FOREIGN KEY (lead_id)
    REFERENCES safetrec.user (id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT FK_agency_id_2
    FOREIGN KEY (agency_id)
    REFERENCES safetrec.agency (id)
    ON DELETE CASCADE
    ON UPDATE CASCADE);

CREATE TABLE safetrec.action_comment (
  id INT NOT NULL AUTO_INCREMENT,
  author VARCHAR(100) NOT NULL,
  comment_date DATETIME NOT NULL,
  comment VARCHAR(5000) NOT NULL,
  action_id INT NOT NULL,
  PRIMARY KEY (id),
  INDEX FK_action_id_idx (action_id ASC),
  CONSTRAINT FK_action_id
    FOREIGN KEY (action_id)
    REFERENCES safetrec.action (id)
    ON DELETE CASCADE
    ON UPDATE CASCADE);
    

CREATE TABLE safetrec.action_output (
  id INT NOT NULL AUTO_INCREMENT,
  description VARCHAR(1000) NOT NULL,
  action_id INT NOT NULL,
  PRIMARY KEY (id),
  INDEX FK_action_id_2_idx (action_id ASC),
  CONSTRAINT FK_action_id_2
    FOREIGN KEY (action_id)
    REFERENCES safetrec.action (id)
    ON DELETE CASCADE
    ON UPDATE CASCADE);
    
CREATE TABLE safetrec.action_output_comment (
  id INT NOT NULL AUTO_INCREMENT,
  author VARCHAR(100) NOT NULL,
  comment_date DATETIME NOT NULL,
  comment VARCHAR(5000) NOT NULL,
  action_output_id INT NOT NULL,
  PRIMARY KEY (id),
  INDEX FK_action_output_id_idx (action_output_id ASC),
  CONSTRAINT FK_action_output_id
    FOREIGN KEY (action_output_id)
    REFERENCES safetrec.action_output (id)
    ON DELETE CASCADE
    ON UPDATE CASCADE);


CREATE TABLE safetrec.action_outcome (
  id INT NOT NULL AUTO_INCREMENT,
  description VARCHAR(1000) NOT NULL,
  action_id INT NOT NULL,
  PRIMARY KEY (id),
  INDEX FK_action_id_3_idx (action_id ASC),
  CONSTRAINT FK_action_id_3
    FOREIGN KEY (action_id)
    REFERENCES safetrec.action (id)
    ON DELETE CASCADE
    ON UPDATE CASCADE);
    
CREATE TABLE safetrec.action_outcome_comment (
  id INT NOT NULL AUTO_INCREMENT,
  author VARCHAR(100) NOT NULL,
  comment_date DATETIME NOT NULL,
  comment VARCHAR(5000) NOT NULL,
  action_outcome_id INT NOT NULL,
  PRIMARY KEY (id),
  INDEX FK_action_outcome_id_idx (action_outcome_id ASC),
  CONSTRAINT FK_action_outcome_id
    FOREIGN KEY (action_outcome_id)
    REFERENCES safetrec.action_outcome (id)
    ON DELETE CASCADE
    ON UPDATE CASCADE);


#insert agency data
select * from agency;
insert into agency values(1, 'ABC', 'Alcoholic Beverage Control');
insert into agency values(2, 'Alameda Co.', 'Alameda County');
insert into agency values(3, 'Anaheim', 'City of Anaheim');
insert into agency values(4, 'ATSSA', 'American Traffic Safety Services Association');
insert into agency values(5, 'BTH', 'California Business, Transportation, and Housing Agency');
insert into agency values(6, 'Butte Co.', 'Butte County');
insert into agency values(7, 'CABO', 'California Association of Bicycling Organizations');
insert into agency values(8, 'Caltrans', 'California Department of Transportation');
insert into agency values(9, 'CDPH', 'California Department of Public Health');
insert into agency values(10, 'CHP', 'California Highway Patrol');
insert into agency values(11, 'CLC', 'California League of Cities');
insert into agency values(12, 'CPCA', "California Police Chief's Association");
insert into agency values(13, 'CS', 'Cambridge Systematics, Inc.');
insert into agency values(14, 'CSAC', 'California State Association of Counties');
insert into agency values(15, 'DMV', 'Department of Motor Vehicles');
insert into agency values(16, 'DSAC', 'Driving School Association of California, Inc.');
insert into agency values(17, 'EMSA', 'Emergency Medical Services Authority');
insert into agency values(18, 'FHWA', 'Federal Highway Administration');
insert into agency values(19, 'FRA', 'Federal Railroad Administration');
insert into agency values(20, 'LA DPH', 'LA County Dept. of Public Health');
insert into agency values(21, 'MTC/RTPA', 'Metropolitan Transportation Commission / Regional Transportation Planning Agency');
insert into agency values(22, 'Nevada Co.', 'Nevada County');
insert into agency values(23, 'OTS', 'Office of Traffic Safety');
insert into agency values(24, 'SafeTREC', 'SafeTREC, UC Berkeley');
insert into agency values(25, 'Santa Rosa', 'City of Santa Rosa');
insert into agency values(26, 'SCAG', 'Nevada County');
insert into agency values(27, 'Nevada Co.', 'Southern California Association of Governments');
insert into agency values(28, 'Tulare Co.', 'Tulare County');
insert into agency values(29, 'UCD', 'UC-Davis Medical Center');
insert into agency values(30, 'WS', 'Walk Sacramento');





