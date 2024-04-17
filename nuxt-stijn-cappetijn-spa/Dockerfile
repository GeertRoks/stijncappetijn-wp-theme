# Use a specific version of Node.js for consistency
ARG NODE_VERSION=20

# Base image with Node.js
FROM node:${NODE_VERSION}-alpine as base

# Set working directory
WORKDIR /app

# Install required packages for node image
#RUN apk --no-cache add openssh g++ make python3 git

# Copy package.json and package-lock.json
COPY package.json /app/
COPY package-lock.json /app/

# Install all dependencies
RUN npm ci && npm cache clean --force

# Copy all files to the work directory
ADD . /app

# Build the project
RUN npm run build

# Expose the host and port 3000 to the server
ENV HOST 0.0.0.0
EXPOSE 3000

# Run the build project with node
ENTRYPOINT ["node", ".output/server/index.mjs"]
