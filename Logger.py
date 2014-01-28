from time import strftime, localtime
from StringIO import StringIO

class Logger(object):

	"""
	filename can be None, it which case logs are buffered in memory until you're ready to write them to a file
	levels is a dictionary of `level: label`, lebel gets prepended to every line of that level
	timestamped turns on timestamping in format [hh:mm:ss]
	append can be flipped to True if you want to continue the log file instead of overwriting it
	"""
	def __init__(self, filename=None, levels=None, timestamped=True, append=False):
		if filename is None:
			self.log = StringIO()
			self.closed = False
		else:
			if append:
				mode = 'a'
			else:
				mode = 'w'
			self.log = open(filename, "w")
			self.closed = self.log.closed
		self.timestamped = timestamped
		self.levels = levels
	
	# if the class was initialised with a null filename, the logs are being written to a buffer. this function moves the buffer into a real file.
	def realize(self, filename):
		if not isinstance(self.log, StringIO):
			return
		buf = self.log.getvalue()
		self.log.close()
		self.log = open(filename, "w")
		self.closed = self.log.closed
		self.log.write(buf)
	
	def close(self):
		self.closed = True
		self.log.close()
		
	def write(self, msg, level=None):
		try:
			msg = msg.strip().encode('utf-8').split('\n')
		except UnicodeDecodeError:
			msg = msg.strip().split('\n')
		
		if len(msg) > 1:
			for m in msg:
				self.write(m, level)
		elif len(msg[0].strip()) > 0:
			if self.timestamped:
				timestamp = strftime("[%H:%M:%S] ", localtime())
			else:
				timestamp = ''
			
			if self.levels is not False and isinstance(self.levels, dict) and level in self.levels.keys():
				self.log.write(timestamp + self.levels[level] + msg[0] + "\n")
			else:
				self.log.write(timestamp + msg[0] + "\n")
			
			self.log.flush()
