CREATE SCHEMA safetrec;

CREATE TABLE safetrec.agency (
  id INT NOT NULL,
  name VARCHAR(45) NOT NULL,
  description VARCHAR(1000) NULL,
  PRIMARY KEY (id));

  CREATE TABLE safetrec.division (
  id INT NOT NULL,
  name VARCHAR(45) NOT NULL,
  description VARCHAR(1000) NULL,
  agency_id INT NOT NULL,
  PRIMARY KEY (id),
  INDEX FK_agency_id_idx (agency_id ASC),
  CONSTRAINT FK_agency_id
    FOREIGN KEY (agency_id)
    REFERENCES safetrec.agency (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


 CREATE TABLE safetrec.user (
  id INT NOT NULL,
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
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

 CREATE TABLE safetrec.challenge_area (
  id INT NOT NULL,
  name VARCHAR(1000) NOT NULL,
  leader1_id INT NOT NULL,
  leader2_id INT NOT NULL,
  PRIMARY KEY (id),
   CONSTRAINT FK_leader1_id
    FOREIGN KEY (leader1_id)
    REFERENCES safetrec.user (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
    CONSTRAINT FK_leader2_id
    FOREIGN KEY (leader2_id)
    REFERENCES safetrec.user (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);
;

 CREATE TABLE safetrec.strategy (
  id INT NOT NULL,
  name VARCHAR(1000) NOT NULL,
  description VARCHAR(2000) NULL,
  challenge_id INT NOT NULL,
  PRIMARY KEY (id),
  INDEX FK_challenge_id_idx (challenge_id ASC),
  CONSTRAINT FK_challenge_id
    FOREIGN KEY (challenge_id)
    REFERENCES safetrec.challenge_area (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

 CREATE TABLE safetrec.action (
  id INT NOT NULL,
  strategy_id INT NOT NULL,
  description VARCHAR(5000) NOT NULL,
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
  PRIMARY KEY (id),
  INDEX FK_strategy_id_idx (strategy_id ASC),
  INDEX FK_division_id_1_idx (division_id ASC),
  INDEX FK_agency_id_2_idx (agency_id ASC),
  CONSTRAINT FK_strategy_id
    FOREIGN KEY (strategy_id)
    REFERENCES safetrec.strategy (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT FK_lead_id
    FOREIGN KEY (lead_id)
    REFERENCES safetrec.user (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT FK_agency_id_2
    FOREIGN KEY (agency_id)
    REFERENCES safetrec.agency (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

CREATE TABLE safetrec.action_comment (
  id INT NOT NULL,
  author VARCHAR(100) NOT NULL,
  comment_date DATETIME NOT NULL,
  comment VARCHAR(5000) NOT NULL,
  action_id INT NOT NULL,
  PRIMARY KEY (id),
  INDEX FK_action_id_idx (action_id ASC),
  CONSTRAINT FK_action_id
    FOREIGN KEY (action_id)
    REFERENCES safetrec.action (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);
    

CREATE TABLE safetrec.action_output (
  id INT NOT NULL,
  description VARCHAR(1000) NOT NULL,
  action_id INT NOT NULL,
  PRIMARY KEY (id),
  INDEX FK_action_id_2_idx (action_id ASC),
  CONSTRAINT FK_action_id_2
    FOREIGN KEY (action_id)
    REFERENCES safetrec.action (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);
    
CREATE TABLE safetrec.action_output_comment (
  id INT NOT NULL,
  author VARCHAR(100) NOT NULL,
  comment_date DATETIME NOT NULL,
  comment VARCHAR(5000) NOT NULL,
  action_output_id INT NOT NULL,
  PRIMARY KEY (id),
  INDEX FK_action_output_id_idx (action_output_id ASC),
  CONSTRAINT FK_action_output_id
    FOREIGN KEY (action_output_id)
    REFERENCES safetrec.action_output (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


CREATE TABLE safetrec.action_outcome (
  id INT NOT NULL,
  description VARCHAR(1000) NOT NULL,
  action_id INT NOT NULL,
  PRIMARY KEY (id),
  INDEX FK_action_id_3_idx (action_id ASC),
  CONSTRAINT FK_action_id_3
    FOREIGN KEY (action_id)
    REFERENCES safetrec.action (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);
    
CREATE TABLE safetrec.action_outcome_comment (
  id INT NOT NULL,
  author VARCHAR(100) NOT NULL,
  comment_date DATETIME NOT NULL,
  comment VARCHAR(5000) NOT NULL,
  action_outcome_id INT NOT NULL,
  PRIMARY KEY (id),
  INDEX FK_action_outcome_id_idx (action_outcome_id ASC),
  CONSTRAINT FK_action_outcome_id
    FOREIGN KEY (action_outcome_id)
    REFERENCES safetrec.action_outcome (id)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);