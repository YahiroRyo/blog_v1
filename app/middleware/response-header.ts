export default (req: any, res: any, next: any) => {
  res.setHeader('Content-Type', 'text/html');
  next();
};