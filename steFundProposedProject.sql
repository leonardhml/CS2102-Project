--Insert failed for rows  1  through  19 
--ORA-01400: cannot insert NULL into ("A0127393"."PROPOSED_PROJECT"."TITLE")
--Row 1
INSERT INTO PROPOSED_PROJECT (TITLE, IN_CHARGE, START_DATE, END_DATE, PROPOSAL_DATE, DESCRIPTION, PROPOSER, TARGET, RAISED, TAG, BANK_ACCT, IS_PAIDAD) VALUES ('test','Testers',to_date('23-Dec-1993', 'DD-MON-RR'),to_date('12-Mar-2000', 'DD-MON-RR'),to_date('20-Dec-1993', 'DD-MON-RR'),'This is a test entry.','test@gmail.com',5000.0,2500.0,'fun','123456',0.0);
--Row 2
INSERT INTO PROPOSED_PROJECT (TITLE, IN_CHARGE, START_DATE, END_DATE, PROPOSAL_DATE, DESCRIPTION, PROPOSER, TARGET, RAISED, TAG, BANK_ACCT, IS_PAIDAD) VALUES ('new toilet','poopers',to_date('23-Dec-1993', 'DD-MON-RR'),to_date('12-Mar-2000', 'DD-MON-RR'),to_date('19-Nov-1992', 'DD-MON-RR'),'New toilet for the school','poop@gmail.com',1000.0,50.0,'education','321999',0.0);
--Row 3
INSERT INTO PROPOSED_PROJECT (TITLE, IN_CHARGE, START_DATE, END_DATE, PROPOSAL_DATE, DESCRIPTION, PROPOSER, TARGET, RAISED, TAG, BANK_ACCT, IS_PAIDAD) VALUES ('help me solve world hunger!','platypus',to_date('12-Mar-2012', 'DD-MON-RR'),to_date('13-Apr-3012', 'DD-MON-RR'),to_date('11-Aug-1990', 'DD-MON-RR'),'I just need some money.','aly@gmail.com',9999999.0,1.0,'medical','999999',0.0);


