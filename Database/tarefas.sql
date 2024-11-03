SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `tarefas` (
  `taskId` int(11) NOT NULL,
  `taskName` varchar(255) NOT NULL,
  `taskPrice` double NOT NULL,
  `taskDate` date NOT NULL,
  `taskOrder` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `tarefas`
  ADD PRIMARY KEY (`taskId`);

ALTER TABLE `tarefas`
  MODIFY `taskId` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;
