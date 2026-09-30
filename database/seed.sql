
INSERT INTO accounts (id, iban, balance_amount, balance_currency) 
VALUES ('bank-reserve-001', 'IR000000000000000000000000', 999999999999, 'IRR')
ON DUPLICATE KEY UPDATE balance_amount = 999999999999;


INSERT INTO accounts (id, iban, balance_amount, balance_currency) 
VALUES ('test-source-001', 'IR111111111111111111111111', 5000000000, 'IRR')
ON DUPLICATE KEY UPDATE balance_amount = 5000000000;


INSERT INTO accounts (id, iban, balance_amount, balance_currency) 
VALUES ('test-dest-001', 'IR222222222222222222222222', 1000000000, 'IRR')
ON DUPLICATE KEY UPDATE balance_amount = 1000000000;

