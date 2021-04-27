CREATE TABLE `ami_proxy` (
  `contact` varchar(128) default NULL,
  `channel` varchar(128) default NULL,
  `port` varchar(128) default '10000',
  `updated_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
); 

