CREATE TABLE member(
email VARCHAR(128) PRIMARY KEY,
name VARCHAR(255) NOT NULL,
address VARCHAR(255) NOT NULL,
password VARCHAR(16) NOT NULL,
is_admin INT NOT NULL CHECK(is_admin=1 OR is_admin=0),
acct VARCHAR(64) NOT NULL,
phone VARCHAR(16) DEFAULT 'not given' NOT NULL
);

CREATE TABLE tag (
word VARCHAR(32) PRIMARY KEY
);

CREATE TABLE proposed_project (
title VARCHAR(64),
in_charge VARCHAR(64),
start_date DATE DEFAULT SYSDATE NOT NULL,
end_date DATE DEFAULT '30-12-9999' NOT NULL,
proposal_date DATE NOT NULL,
description VARCHAR(512),
proposer VARCHAR(128) REFERENCES member(email) ON DELETE CASCADE,
target NUMBER(*, 2) NOT NULL CHECK(target > 0),
tag VARCHAR(32) REFERENCES tag(word) ON DELETE CASCADE,
bank_acct VARCHAR(32) NOT NULL,
is_paidAd INT NOT NULL CHECK (is_paidAd = 0 OR is_paidAd = 1),
PRIMARY KEY (title, in_charge),
CHECK (proposal_date <= start_date AND end_date >= start_date)
);

CREATE TABLE fund_record (
fund_date_time TIMESTAMP DEFAULT LOCALTIMESTAMP NOT NULL,
amount NUMBER(*,2) NOT NULL,
message VARCHAR(256),
id INT PRIMARY KEY,
donor VARCHAR(128),
p_title VARCHAR(64),
p_in_charge VARCHAR(64),
FOREIGN KEY (donor) REFERENCES member(email) ON DELETE CASCADE,
FOREIGN KEY (p_title, p_in_charge) REFERENCES proposed_project (title, in_charge) ON DELETE CASCADE
);

CREATE TABLE p_vote (
rating NUMBER(3,2) CHECK (rating >=0.00 AND rating <= 5.00),
voter VARCHAR(128),
p_title VARCHAR(64),
p_in_charge VARCHAR(64),
PRIMARY KEY (voter, p_title, p_in_charge),
FOREIGN KEY (voter) REFERENCES member(email) ON DELETE CASCADE,
FOREIGN KEY (p_title, p_in_charge) REFERENCES proposed_project (title, in_charge) ON DELETE CASCADE
);

CREATE TABLE m_vote (
rating NUMBER(3,2) CHECK (rating >=0.00 AND rating <= 5.00),
voter VARCHAR(128),
votee VARCHAR(128),
PRIMARY KEY (voter, votee),
FOREIGN KEY (voter) REFERENCES member(email) ON DELETE CASCADE,
FOREIGN KEY (votee) REFERENCES member(email) ON DELETE CASCADE,
CHECK (voter <> votee)
);

CREATE SEQUENCE seq_ID
MINVALUE 1
START WITH 1
INCREMENT BY 1
CACHE 10;

CREATE VIEW top_projects AS
(SELECT v.p_title AS title, v.p_in_charge AS in_charge, avg(v.rating) AS rating
FROM p_vote v
GROUP BY v.p_title, v.p_in_charge)
UNION
(SELECT p.title AS title, p.in_charge AS in_charge, 0.00 AS rating
FROM proposed_project p
WHERE (p.title, p.in_charge) NOT IN (
  SELECT vo.p_title, vo.p_in_charge
  FROM p_vote vo)
);

SELECT * FROM top_projects ORDER BY rating DESC;