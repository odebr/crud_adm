ALTER TABLE `btrulead_leads`.`merchant_gateways` 
ADD COLUMN `paypalSandboxClientID` VARCHAR(255) NULL AFTER `authorizeNetLiveTransactionKey`,
ADD COLUMN `paypalSandboxClientSecret` VARCHAR(255) NULL AFTER `paypalSandboxClientID`,
ADD COLUMN `paypalProdClientID` VARCHAR(255) NULL AFTER `paypalSandboxClientSecret`,
ADD COLUMN `paypalProdClientSecret` VARCHAR(255) NULL AFTER `paypalProdClientID`;
