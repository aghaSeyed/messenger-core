CREATE TABLE IF NOT EXISTS accounts (
    id VARCHAR(36) PRIMARY KEY,
    iban VARCHAR(26) NOT NULL UNIQUE,
    balance_amount BIGINT NOT NULL DEFAULT 0,
    balance_currency VARCHAR(3) NOT NULL DEFAULT 'IRR',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_iban (iban)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS transfers (
    id VARCHAR(36) PRIMARY KEY,
    amount BIGINT NOT NULL,
    currency VARCHAR(3) NOT NULL DEFAULT 'IRR',
    source_iban VARCHAR(26) NOT NULL,
    destination_iban VARCHAR(26) NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'pending',
    note TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_status (status),
    INDEX idx_source_iban (source_iban),
    INDEX idx_destination_iban (destination_iban),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;